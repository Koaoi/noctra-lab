<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URI yang dikecualikan dari CSRF verification.
     * Midtrans callback dikirim dari server Midtrans,
     * sehingga tidak membawa CSRF token.
     */
    protected $except = [
        'midtrans/callback',
    ];
}