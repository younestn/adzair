<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SocialPage extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'page_url',
        'verification_code',
        'status',
        'rejection_reason',
        'page_name',
        'followers_count',
        'page_category',
        'profile_picture_url',
        'phone_number',
        'activity_location',
        'most_viewed_wilayas',
        'most_followed_wilayas',
        'audience_reach_rate',
        'page_topics',
        'cpc_publisher',
    ];

    protected $casts = [
        'most_viewed_wilayas' => 'array',
        'most_followed_wilayas' => 'array',
        'page_topics' => 'array',
        'audience_reach_rate' => 'decimal:2',
        'cpc_publisher' => 'decimal:4',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateVerificationCode(): string
    {
        do {
            $code = 'adzair_' . strtolower(Str::random(8));
        } while (self::where('verification_code', $code)->exists());

        return $code;
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
}
