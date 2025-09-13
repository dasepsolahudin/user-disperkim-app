<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // PERBAIKAN: Tambahkan middleware ini
            \App\Http\Middleware\SetLocale::class,
        ],

        'api' => [
            // ... middleware api
        ],
    ];
    // ...

    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        // ...middleware lainnya
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // <-- PASTIKAN BARIS INI ADA
    ];
}