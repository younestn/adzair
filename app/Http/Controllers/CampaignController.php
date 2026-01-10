<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('advertiser')->except(['index', 'show']);
    }

    public function index(): View
    {
        $campaigns = Auth::user()->campaigns()->latest()->paginate(15);
        return view('advertiser.campaigns.index', compact('campaigns'));
    }

    public function create(): View
    {
        return view('advertiser.campaigns.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'budget' => 'required|numeric|min:10',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $campaign = Auth::user()->campaigns()->create([
            ...\$validated,
            'status' => 'pending',
            'spent' => 0,
        ]);

        return redirect()->route('advertiser.campaigns.show', $campaign)->with('status', 'Campaign created successfully! Awaiting admin approval.');
    }

    public function show(Campaign $campaign): View
    {
        if ($campaign->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $ads = $campaign->ads()->latest()->get();
        $impressionCount = $campaign->getImpressionCount();
        $clickCount = $campaign->getClickCount();
        $ctr = $campaign->getCTR();

        return view('advertiser.campaigns.show', compact('campaign', 'ads', 'impressionCount', 'clickCount', 'ctr'));
    }

    public function edit(Campaign $campaign): View
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        return view('advertiser.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign): RedirectResponse
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'budget' => 'required|numeric|min:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $campaign->update($validated);

        return redirect()->route('advertiser.campaigns.show', $campaign)->with('status', 'Campaign updated successfully!');
    }

    public function toggle(Campaign $campaign): RedirectResponse
    {
        if ($campaign->user_id !== Auth::id() || $campaign->status !== 'active') {
            abort(403);
        }

        $campaign->update([
            'status' => $campaign->status === 'active' ? 'paused' : 'active',
        ]);

        return back()->with('status', 'Campaign updated successfully!');
    }
}
