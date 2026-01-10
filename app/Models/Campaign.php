<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'budget',
        'spent',
        'start_date',
        'end_date',
        'status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function impressions(): HasMany
    {
        return $this->hasMany(Impression::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    public function getImpressionCount()
    {
        return $this->impressions()->count();
    }

    public function getClickCount()
    {
        return $this->clicks()->count();
    }

    public function getCTR()
    {
        $impressions = $this->getImpressionCount();
        if ($impressions === 0) return 0;
        return ($this->getClickCount() / $impressions) * 100;
    }

    public function getRemainingBudget()
    {
        return $this->budget - $this->spent;
    }

    public function isActive()
    {
        return $this->status === 'active' && now()->between($this->start_date, $this->end_date);
    }
}
