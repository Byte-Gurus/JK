<?php

use App\Http\Middleware\CheckIfLoggedIn;
use App\Http\Middleware\RedirectIfLoggedIn;
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

            'RedirectIfLoggedIn' => \App\Http\Middleware\RedirectIfLoggedIn::class,
            'CheckIfLoggedIn' => \App\Http\Middleware\CheckIfLoggedIn::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
