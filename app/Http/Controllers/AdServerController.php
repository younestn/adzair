<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Website;
use App\Models\Impression;
use App\Models\Click;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class AdServerController extends Controller
{
    public function serve(Request $request): JsonResponse
    {
        $websiteId = $request->query('website_id');
        $website = Website::find($websiteId);

        if (!$website || $website->status !== 'active') {
            return response()->json(['error' => 'Invalid website'], 404);
        }

        $activeCampaigns = Campaign::where('status', 'active')
            ->where('approved_at', '!=', null)
            ->whereDate('start_date', '<=', Carbon::today())
            ->whereDate('end_date', '>=', Carbon::today())
            ->get();

        $availableAds = [];
        foreach ($activeCampaigns as $campaign) {
            if ($campaign->getRemainingBudget() > 0) {
                $ads = $campaign->ads()->where('status', 'active')->get();
                foreach ($ads as $ad) {
                    $availableAds[] = [
                        'id' => $ad->id,
                        'campaign_id' => $campaign->id,
                        'type' => $ad->type,
                        'content' => $ad->content,
                        'image_url' => $ad->image_url,
                        'destination_url' => $ad->destination_url,
                        'weight' => $campaign->getRemainingBudget(),
                    ];
                }
            }
        }

        if (empty($availableAds)) {
            return response()->json(['ad' => null]);
        }

        $selectedAd = $availableAds[array_rand($availableAds)];

        return response()->json(['ad' => $selectedAd]);
    }

    public function trackImpression(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'ad_id' => 'required|exists:ads,id',
            'website_id' => 'required|exists:websites,id',
        ]);

        $userAgent = $request->header('User-Agent');
        $ipAddress = $request->ip();

        // Check for duplicate within 24 hours
        $duplicate = Impression::where('campaign_id', $validated['campaign_id'])
            ->where('website_id', $validated['website_id'])
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->where('timestamp', '>=', Carbon::now()->subHours(24))
            ->exists();

        if (!$duplicate) {
            Impression::create([
                'campaign_id' => $validated['campaign_id'],
                'ad_id' => $validated['ad_id'],
                'website_id' => $validated['website_id'],
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'timestamp' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function trackClick(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'ad_id' => 'required|exists:ads,id',
            'website_id' => 'required|exists:websites,id',
        ]);

        $userAgent = $request->header('User-Agent');
        $ipAddress = $request->ip();

        Click::create([
            'campaign_id' => $validated['campaign_id'],
            'ad_id' => $validated['ad_id'],
            'website_id' => $validated['website_id'],
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
            'timestamp' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
