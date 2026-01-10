<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    protected $fillable = [
        'user_id',
        'website_id',
        'ad_id',
        'impressions',
        'clicks',
        'amount',
        'period',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
