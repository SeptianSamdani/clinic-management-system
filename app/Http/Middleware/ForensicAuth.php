<?php

// ==========================================
// app/Http/Middleware/ForensicAuth.php
// ==========================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForensicAuth
{
    /**
     * Handle an incoming request for forensic dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('forensic_authenticated')) {
            return redirect()->route('forensic.login');
        }

        return $next($request);
    }
}