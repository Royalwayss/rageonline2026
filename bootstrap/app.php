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

        // CSRF exemption for webhook/callback routes.
        // Delhivery cannot send a CSRF token, so its webhook is exempt.
        // Payment gateway routes (Razorpay, Phonepe, Payu, Ccavenue) can be
        // added here too once confirmed:
        //     'webhook-razorpay', 'phonepe/callback', 'payu-money-callback', 'ccavenue/response'
        $middleware->validateCsrfTokens(except: [
            'delhivery/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();