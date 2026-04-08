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
        'media_type',
        'content',
        'image_url',
        'media_path',
        'media_url',
        'headline',
        'description',
        'destination_url',
        'tracking_slug',
        'target_url',
        'is_product_ad',
        'sales_count',
        'status',
    ];

    protected $casts = [
        'is_product_ad' => 'boolean',
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

    public function assignments(): HasMany
    {
        return $this->hasMany(AdPageAssignment::class);
    }
}
