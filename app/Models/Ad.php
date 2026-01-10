<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    protected $fillable = [
        'campaign_id',
        'type',
        'content',
        'image_url',
        'destination_url',
        'status',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function impressions(): HasMany
    {
        return $this->hasMany(Impression::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }
}
