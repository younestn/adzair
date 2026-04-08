<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocialPageRequest;
use App\Http\Requests\UpdateSocialPageManualInfoRequest;
use App\Models\Earning;
use App\Models\SocialPage;
use App\Models\Website;
use App\Models\Withdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('publisher');
    }

    public function dashboard(): View
    {
        $user = Auth::user();
        $websites = $user->websites()->get();
        $totalEarnings = $user->earnings()->sum('amount');
        $pendingWithdrawals = $user->withdrawals()->where('status', 'pending')->sum('amount');

        return view('publisher.dashboard', compact('websites', 'totalEarnings', 'pendingWithdrawals'));
    }

    public function websites(): View
    {
        $websites = Auth::user()->websites()->latest()->paginate(15);

        return view('publisher.websites.index', compact('websites'));
    }

    public function createWebsite(): View
    {
        return view('publisher.websites.create');
    }

    public function storeWebsite(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:websites,url',
            'category' => 'required|string|max:100',
        ]);

        Auth::user()->websites()->create([
            ...$validated,
            'status' => 'active',
        ]);

        return redirect()->route('publisher.websites')->with('status', 'Website registered successfully!');
    }

    public function showWebsite(Website $website): View
    {
        if ($website->user_id !== Auth::id()) {
            abort(403);
        }

        $impressions = $website->impressions()->count();
        $clicks = $website->clicks()->count();
        $earnings = $website->earnings()->sum('amount');
        $snippet = $website->snippet_code;

        return view('publisher.websites.show', compact('website', 'impressions', 'clicks', 'earnings', 'snippet'));
    }

    public function earnings(): View
    {
        $earnings = Auth::user()->earnings()->latest()->paginate(20);
        $totalEarnings = Auth::user()->earnings()->sum('amount');

        return view('publisher.earnings', compact('earnings', 'totalEarnings'));
    }

    public function requestWithdrawal(): View
    {
        $user = Auth::user();
        $availableBalance = $user->earnings()->sum('amount') - $user->withdrawals()->where('status', '!=', 'rejected')->sum('amount');

        return view('publisher.withdrawal', compact('availableBalance'));
    }

    public function storeWithdrawal(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $availableBalance = $user->earnings()->sum('amount') - $user->withdrawals()->where('status', '!=', 'rejected')->sum('amount');

        $validated = $request->validate([
            'amount' => "required|numeric|min:10|max:$availableBalance",
        ]);

        $user->withdrawals()->create([
            'amount' => $validated['amount'],
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return redirect()->route('publisher.dashboard')->with('status', 'Withdrawal request submitted!');
    }

    /**
     * Display social pages for the authenticated publisher.
     */
    public function socialPages(): View
    {
        $pages = Auth::user()->socialPages()->latest()->paginate(15);

        return view('publisher.social-pages.index', compact('pages'));
    }

    /**
     * Show form for creating a social page.
     */
    public function createSocialPage(): View
    {
        return view('publisher.social-pages.create');
    }

    /**
     * Store a social page and auto-fetch Open Graph metadata.
     */
    public function storeSocialPage(StoreSocialPageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $verificationCode = SocialPage::generateVerificationCode();
        $meta = $this->extractOpenGraphData($validated['page_url']);

        $page = Auth::user()->socialPages()->create([
            'platform' => $validated['platform'],
            'page_url' => $validated['page_url'],
            'verification_code' => $verificationCode,
            'status' => 'pending',
            'page_name' => $meta['title'],
            'page_category' => $meta['description'],
            'profile_picture_url' => $meta['image'],
        ]);

        return redirect()->route('publisher.social-pages.verify-instructions', $page)
            ->with('status', 'Page added. Please complete verification.');
    }

    /**
     * Show verification instructions for a social page.
     */
    public function showVerificationInstructions(SocialPage $page): View
    {
        $this->authorizePageOwnership($page);

        return view('publisher.social-pages.verify-instructions', compact('page'));
    }

    /**
     * Show manual social page info edit form.
     */
    public function editSocialPageManualInfo(SocialPage $page): View
    {
        $this->authorizePageOwnership($page);

        return view('publisher.social-pages.manual-info', [
            'page' => $page,
            'wilayas' => config('algeria.wilayas', []),
        ]);
    }

    /**
     * Update manual social page fields.
     */
    public function updateSocialPageManualInfo(UpdateSocialPageManualInfoRequest $request, SocialPage $page): RedirectResponse
    {
        $this->authorizePageOwnership($page);

        $page->update($request->validated());

        return redirect()->route('publisher.social-pages.index')->with('status', 'Manual info updated successfully.');
    }

    /**
     * Ensure current user owns the social page.
     */
    private function authorizePageOwnership(SocialPage $page): void
    {
        if ($page->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * Extract basic Open Graph attributes from a URL.
     *
     * @return array{title: string|null, description: string|null, image: string|null}
     */
    private function extractOpenGraphData(string $url): array
    {
        try {
            $response = Http::timeout(8)->get($url);
            if (! $response->successful()) {
                return ['title' => null, 'description' => null, 'image' => null];
            }

            $html = $response->body();

            return [
                'title' => $this->extractMetaContent($html, 'og:title') ?? $this->extractTitle($html),
                'description' => $this->extractMetaContent($html, 'og:description'),
                'image' => $this->extractMetaContent($html, 'og:image'),
            ];
        } catch (\Throwable $exception) {
            return ['title' => null, 'description' => null, 'image' => null];
        }
    }

    /**
     * Read a specific meta property from HTML.
     */
    private function extractMetaContent(string $html, string $property): ?string
    {
        $pattern = '/<meta[^>]+(?:property|name)=["\']' . preg_quote($property, '/') . '["\'][^>]+content=["\']([^"\']+)["\']/i';
        preg_match($pattern, $html, $matches);

        return $matches[1] ?? null;
    }

    /**
     * Extract the page title from HTML.
     */
    private function extractTitle(string $html): ?string
    {
        preg_match('/<title>(.*?)<\/title>/is', $html, $matches);

        return isset($matches[1]) ? trim(strip_tags($matches[1])) : null;
    }
}
