<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    /**
     * Store a newly created ad for a campaign.
     */
    public function store(StoreAdRequest $request, Campaign $campaign): RedirectResponse
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validated();
        $mediaPath = null;
        $mediaType = 'text';

        if ($request->hasFile('media_file')) {
            $mediaPath = $request->file('media_file')->store('ads/media', 'public');
            $extension = strtolower((string) $request->file('media_file')->getClientOriginalExtension());
            $mediaType = in_array($extension, ['mp4', 'mov'], true) ? 'video' : 'image';
        }

        $campaign->ads()->create([
            'type' => $validated['type'],
            'content' => $validated['content'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'destination_url' => $validated['destination_url'],
            'target_url' => $validated['target_url'] ?? $validated['destination_url'],
            'tracking_slug' => Str::random(16),
            'is_product_ad' => (bool) ($validated['is_product_ad'] ?? false),
            'media_type' => $mediaPath ? $mediaType : ($validated['type'] === 'image' ? 'image' : 'text'),
            'media_path' => $mediaPath,
            'media_url' => $validated['media_url'] ?? null,
            'headline' => $validated['headline'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        $campaign->update([
            'target_wilayas' => $validated['target_wilayas'] ?? $campaign->target_wilayas,
            'target_audience' => $validated['target_audience'] ?? $campaign->target_audience,
            'niche' => $validated['niche'],
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
