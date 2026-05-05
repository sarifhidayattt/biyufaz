<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- TAMBAHKAN BAGIAN INI ---
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        // ----------------------------

        // (Jika Anda punya konfigurasi CSRF midtrans sebelumnya, biarkan saja di sini)
         $middleware->validateCsrfTokens(except: [
            'midtrans-callback' 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();