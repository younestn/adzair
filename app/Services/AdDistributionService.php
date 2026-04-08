<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AdPageAssignment;
use App\Models\SocialPage;
use App\Notifications\AdAssignedNotification;

class AdDistributionService
{
    /**
     * Distribute an ad to matching verified social pages.
     */
    public function distributeAd(Ad $ad): void
    {
        $campaign = $ad->campaign()->first();
        if ($campaign === null || (float) $campaign->budget <= (float) $campaign->spent_amount) {
            return;
        }

        $targetWilayas = $campaign->target_wilayas ?? [];
        $niche = $campaign->niche;

        $query = SocialPage::query()->where('status', 'verified');

        if (! empty($niche)) {
            $query->whereJsonContains('page_topics', $niche);
        }

        if (! empty($targetWilayas)) {
            $query->where(function ($builder) use ($targetWilayas): void {
                foreach ($targetWilayas as $wilaya) {
                    $builder->orWhereJsonContains('most_viewed_wilayas', $wilaya)
                        ->orWhereJsonContains('most_followed_wilayas', $wilaya);
                }
            });
        }

        $pages = $query->get();

        foreach ($pages as $page) {
            $assignment = AdPageAssignment::firstOrCreate(
                ['ad_id' => $ad->id, 'social_page_id' => $page->id],
                ['status' => 'pending', 'assigned_at' => now()]
            );

            $page->user->notify(new AdAssignedNotification($assignment));
        }
    }
}
