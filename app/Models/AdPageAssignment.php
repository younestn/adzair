<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdPageAssignment extends Model
{
    protected $fillable = [
        'ad_id',
        'social_page_id',
        'status',
        'assigned_at',
        'started_at',
        'ended_at',
        'impressions_count',
        'clicks_count',
        'publisher_earnings',
        'advertiser_cost',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'publisher_earnings' => 'decimal:4',
        'advertiser_cost' => 'decimal:4',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function socialPage(): BelongsTo
    {
        return $this->belongsTo(SocialPage::class);
    }
}
