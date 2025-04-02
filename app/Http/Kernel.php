<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\VerifyToken;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'verify.token' => \App\Http\Middleware\VerifyToken::class,
        'verify.token.cookie' => \App\Http\Middleware\VerifyTokenCookie::class,
    ];
}
