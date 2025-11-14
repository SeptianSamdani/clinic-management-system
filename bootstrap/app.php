<?php

// ==========================================
// bootstrap/app.php (Laravel 11)
// ==========================================

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
        // Register middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'forensic.auth' => \App\Http\Middleware\ForensicAuth::class,
        ]);
        
        // Append global middleware (will run on ALL requests)
        $middleware->append([
            \App\Http\Middleware\ForensicLogger::class,
            \App\Http\Middleware\SqlQueryLogger::class,
        ]);
        
        // IMPORTANT: Disable CSRF for vulnerable endpoints (for forensic training)
        // In production, NEVER do this!
        $middleware->validateCsrfTokens(except: [
            '*', // Disable CSRF on ALL routes - VULNERABLE!
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();