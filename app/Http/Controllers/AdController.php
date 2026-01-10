<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Campaign $campaign): \Illuminate\View\View
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        return view('advertiser.ads.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign): RedirectResponse
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:image,text',
            'content' => 'required_if:type,text|string|max:500',
            'image_url' => 'required_if:type,image|url',
            'destination_url' => 'required|url',
        ]);

        $campaign->ads()->create([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()->route('advertiser.campaigns.show', $campaign)->with('status', 'Ad created successfully!');
    }

    public function destroy(Ad $ad): RedirectResponse
    {
        $campaign = $ad->campaign;

        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        $ad->delete();

        return back()->with('status', 'Ad deleted successfully!');
    }
}
