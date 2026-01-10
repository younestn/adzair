<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    protected $fillable = [
        'campaign_id',
        'ad_id',
        'website_id',
        'user_agent',
        'ip_address',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public $timestamps = false;

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
