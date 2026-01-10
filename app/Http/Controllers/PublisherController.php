<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Earning;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
}
