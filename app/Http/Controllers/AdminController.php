<?php

namespace App\Http\Controllers;

use App\Http\Requests\RejectSocialPageRequest;
use App\Http\Requests\SetPricingRequest;
use App\Http\Requests\SetUserPricingRequest;
use App\Models\Ad;
use App\Models\Campaign;
use App\Models\PricingRule;
use App\Models\SocialPage;
use App\Models\User;
use App\Models\Withdrawal;
use App\Services\AdDistributionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard(): View
    {
        $totalUsers = User::count();
        $advertisers = User::where('role', 'advertiser')->count();
        $publishers = User::where('role', 'publisher')->count();
        $pendingCampaigns = Campaign::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalUsers', 'advertisers', 'publishers', 'pendingCampaigns'));
    }

    public function users(): View
    {
        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function campaigns(): View
    {
        $campaigns = Campaign::where('status', 'pending')->latest()->paginate(20);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function approveCampaign(Campaign $campaign): RedirectResponse
    {
        $campaign->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('status', 'Campaign approved successfully!');
    }

    public function rejectCampaign(Campaign $campaign, \Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $campaign->update([
            'status' => 'rejected',
        ]);

        return back()->with('status', 'Campaign rejected.');
    }

    public function ads(): View
    {
        $ads = Ad::where('status', 'pending')->latest()->paginate(20);

        return view('admin.ads.index', compact('ads'));
    }

    public function approveAd(Ad $ad): RedirectResponse
    {
        $ad->update(['status' => 'active']);
        app(AdDistributionService::class)->distributeAd($ad);

        return back()->with('status', 'Ad approved successfully!');
    }

    public function rejectAd(Ad $ad): RedirectResponse
    {
        $ad->update(['status' => 'rejected']);

        return back()->with('status', 'Ad rejected.');
    }

    public function withdrawals(): View
    {
        $withdrawals = Withdrawal::where('status', 'pending')->latest()->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approveWithdrawal(Withdrawal $withdrawal): RedirectResponse
    {
        $withdrawal->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Withdrawal approved!');
    }

    public function rejectWithdrawal(Withdrawal $withdrawal): RedirectResponse
    {
        $withdrawal->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return back()->with('status', 'Withdrawal rejected.');
    }

    /**
     * List pending social pages for admin review.
     */
    public function socialPages(): View
    {
        $pages = SocialPage::where('status', 'pending')->latest()->paginate(30);

        return view('admin.social-pages.index', compact('pages'));
    }

    /**
     * Verify social page by checking verification code in page content.
     */
    public function verifySocialPage(SocialPage $page): RedirectResponse
    {
        try {
            $response = Http::timeout(8)->get($page->page_url);
            if (! $response->successful()) {
                return back()->with('error', 'تعذر الوصول إلى الصفحة للتحقق.');
            }

            if (str_contains(strtolower($response->body()), strtolower($page->verification_code))) {
                $page->update([
                    'status' => 'verified',
                    'rejection_reason' => null,
                ]);

                return back()->with('status', 'تم التحقق من الصفحة بنجاح.');
            }

            return back()->with('error', 'الكود غير موجود في وصف الصفحة');
        } catch (\Throwable $exception) {
            return back()->with('error', 'فشل التحقق بسبب خطأ في الاتصال.');
        }
    }

    /**
     * Reject a social page with reason.
     */
    public function rejectSocialPage(RejectSocialPageRequest $request, SocialPage $page): RedirectResponse
    {
        $page->update([
            'status' => 'rejected',
            'rejection_reason' => $request->validated('rejection_reason'),
        ]);

        return back()->with('status', 'تم رفض الصفحة.');
    }

    /**
     * Show full social page details for admin.
     */
    public function showSocialPageAdmin(SocialPage $page): View
    {
        return view('admin.social-pages.show', compact('page'));
    }

    /**
     * Set pricing for campaign/social page and create pricing rule.
     */
    public function setPricing(SetPricingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated): void {
            if (! empty($validated['campaign_id'])) {
                Campaign::whereKey($validated['campaign_id'])->update(['cpc_price' => $validated['cpc']]);
            }

            if (! empty($validated['social_page_id'])) {
                SocialPage::whereKey($validated['social_page_id'])->update(['cpc_publisher' => $validated['cpc']]);
            }

            PricingRule::create([
                'type' => $validated['type'],
                'user_id' => null,
                'platform' => $validated['platform'] ?? null,
                'default_cpc' => $validated['cpc'],
                'is_global' => (bool) ($validated['is_global'] ?? false),
            ]);
        });

        return back()->with('status', 'Pricing updated successfully.');
    }

    /**
     * Set default pricing for a specific user.
     */
    public function setPricingForUser(SetUserPricingRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        PricingRule::create([
            'type' => $validated['type'],
            'user_id' => $user->id,
            'platform' => $validated['platform'] ?? null,
            'default_cpc' => $validated['cpc'],
            'is_global' => false,
        ]);

        return back()->with('status', 'User pricing updated successfully.');
    }
}
