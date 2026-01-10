<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Ad;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
            'approved_by' => auth()->id(),
        ]);

        return back()->with('status', 'Campaign approved successfully!');
    }

    public function rejectCampaign(Campaign $campaign, Request $request): RedirectResponse
    {
        $validated = $request->validate([
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
}
