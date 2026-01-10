<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function websites()
    {
        return $this->hasMany(Website::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAdvertiser()
    {
        return $this->role === 'advertiser';
    }

    public function isPublisher()
    {
        return $this->role === 'publisher';
    }
}
