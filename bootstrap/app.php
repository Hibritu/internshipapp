<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
        'is_admin' => \App\Http\Middleware\IsAdmin::class,
        'setlocale' => \App\Http\Middleware\SetLocale::class, 
        // ✅ Register alias properly
    ]);
        $middleware->group('api', [
            \App\Http\Middleware\SetLocale::class, // ✅ Apply SetLocale middleware to API routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
