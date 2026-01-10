<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Website extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'url',
        'category',
        'status',
        'snippet_code',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->snippet_code = 'snippet_' . Str::random(32);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
