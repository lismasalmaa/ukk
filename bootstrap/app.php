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
        $middleware->alias([
            'isGuest' => \App\Http\Middleware\IsGuest::class,
            'isLogin' => \App\Http\Middleware\IsLogin::class,
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'isEmployee' => \App\Http\Middleware\IsEmployee::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
