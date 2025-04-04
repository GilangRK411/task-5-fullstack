<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifyToken;
use App\Http\Middleware\VerifyTokenFromCookie;

class Kernel extends HttpKernel
{
    /**
     * Middleware global yang selalu dijalankan
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class, // Pastikan ini ada
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    ];

    /**
     * Middleware Groups
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class, // Pastikan ini ada
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Session\Middleware\StartSession::class, // Tambahkan jika butuh sesi di API
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:api',
        ],
    ];

    /**
     * Middleware yang bisa dipanggil secara individu pada route
     */
    protected $routeMiddleware = [
        'admin' => AdminMiddleware::class,
        'verify.token' => VerifyToken::class,
        'verify.token.cookie' => VerifyTokenFromCookie::class,
    ];
}
