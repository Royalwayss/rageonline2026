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
        // Registers the custom 'admin' middleware alias
        // (was $routeMiddleware['admin'] in the old Kernel.php)
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
        ]);

        // If your payment gateway webhook/callback routes (Razorpay, Phonepe,
        // Payu, Ccavenue) need CSRF exemption, add their URIs here.
        // Uncomment and fill in once confirmed:
        // $middleware->validateCsrfTokens(except: [
        //     'webhook-razorpay',
        //     'phonepe/callback',
        //     'payu-money-callback',
        //     'ccavenue/response',
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();