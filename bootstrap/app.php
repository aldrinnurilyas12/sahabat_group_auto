<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            // daftar middleware untuk web
            \App\Http\Middleware\CheckMaintenanceMode::class,
            // tambahkan lainnya jika perlu
        ]);

        $middleware->api([
            \App\Http\Middleware\CheckMaintenanceMode::class,
            // untuk grup API
        ]);

        $middleware->alias([
            'check_maintenance' => \App\Http\Middleware\CheckMaintenanceMode::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
