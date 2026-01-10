<?php

namespace App\Http\Middleware;

Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    protected $except = [
        'api/ads/track/*',
    ];
}
