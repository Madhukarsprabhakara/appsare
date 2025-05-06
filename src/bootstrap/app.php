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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            
        ]);

        //
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: [
            '192.168.1.2',
            '*',
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            
            'http://localhost/snotifications',
            'http://localhost/trackeranalytics',
            '/snotifications',
            '/trackeranalytics',
            'https://appsare.com/snotifications',
            'https://appsare.com/trackeranalytics',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
