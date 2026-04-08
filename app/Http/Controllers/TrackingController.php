<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Click;
use App\Models\Earning;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TrackingController extends Controller
{
    /**
     * Track click and redirect to ad target URL.
     */
    public function redirectAd(string $slug, Request $request): RedirectResponse
    {
        $ad = Ad::with(['campaign', 'assignments.socialPage'])->where('tracking_slug', $slug)->firstOrFail();
        $campaign = $ad->campaign;
        $assignment = $ad->assignments()->with('socialPage')->whereIn('status', ['pending', 'active'])->first();

        $geoData = $this->resolveGeoData($request->ip());
        $cpcPublisher = (float) ($assignment?->socialPage?->cpc_publisher ?? 0);
        $cpcAdvertiser = (float) ($campaign->cpc_price ?? 0);

        $websiteId = $assignment?->socialPage?->user?->websites()->value('id') ?? Website::query()->value('id');
        if ($websiteId === null) {
            $websiteId = Website::create([
                'user_id' => $campaign->user_id,
                'name' => 'Tracking Placeholder',
                'url' => 'https://placeholder-' . uniqid() . '.adzair.local',
                'category' => 'tracking',
                'status' => 'active',
            ])->id;
        }

        DB::transaction(function () use ($ad, $campaign, $assignment, $request, $geoData, $cpcPublisher, $cpcAdvertiser, $websiteId): void {
            Click::create([
                'campaign_id' => $campaign->id,
                'ad_id' => $ad->id,
                'website_id' => $websiteId,
                'social_page_id' => $assignment?->social_page_id,
                'user_agent' => $request->userAgent() ?? 'unknown',
                'ip_address' => $request->ip(),
                'country' => $geoData['country'] ?? null,
                'wilaya' => $geoData['regionName'] ?? null,
                'timestamp' => now(),
            ]);

            if ($assignment !== null) {
                Earning::create([
                    'user_id' => $assignment->socialPage->user_id,
                    'website_id' => null,
                    'ad_id' => $ad->id,
                    'impressions' => 0,
                    'clicks' => 1,
                    'amount' => $cpcPublisher,
                    'period' => now()->format('Y-m-d'),
                ]);

                $assignment->increment('clicks_count');
                $assignment->increment('publisher_earnings', $cpcPublisher);
                $assignment->increment('advertiser_cost', $cpcAdvertiser);
            }

            $campaign->increment('spent_amount', $cpcAdvertiser);
        });

        return redirect()->away($ad->target_url ?: $ad->destination_url);
    }

    /**
     * Return ad statistics as JSON.
     */
    public function adStats(Ad $ad): JsonResponse
    {
        $clicks = $ad->clicks()->count();
        $impressions = $ad->impressions()->count();
        $ctr = $impressions > 0 ? round(($clicks / $impressions) * 100, 2) : 0;

        return response()->json([
            'ad_id' => $ad->id,
            'total_clicks' => $clicks,
            'total_impressions' => $impressions,
            'total_sales' => $ad->sales_count,
            'ctr' => $ctr,
            'total_spent' => (float) $ad->assignments()->sum('advertiser_cost'),
        ]);
    }

    /**
     * Resolve geo data using ip-api.com.
     *
     * @return array<string, mixed>
     */
    private function resolveGeoData(?string $ip): array
    {
        if (empty($ip)) {
            return [];
        }

        try {
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $exception) {
            return [];
        }

        return [];
    }
}
