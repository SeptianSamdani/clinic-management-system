<?php

// ==========================================
// app/Http/Middleware/ForensicLogger.php
// ==========================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ForensicLogger
{
    /**
     * Handle an incoming request and log everything for forensic analysis.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        // Process the request
        $response = $next($request);
        
        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // in milliseconds

        // Log request details
        try {
            DB::table('request_logs')->insert([
                'ip_address' => $request->ip(),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
                'request_body' => json_encode($request->except(['password', 'password_confirmation'])),
                'response_code' => $response->getStatusCode(),
                'created_at' => now(),
            ]);

            // Detect suspicious patterns
            $this->detectSuspiciousActivity($request);
            
        } catch (\Exception $e) {
            Log::error('Failed to log request: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Detect suspicious activity patterns
     */
    private function detectSuspiciousActivity(Request $request): void
    {
        $suspiciousPatterns = [
            'sql_injection' => [
                "/'.*OR.*'/i",
                "/UNION.*SELECT/i",
                "/--/",
                "/;.*DROP/i",
                "/;.*DELETE/i",
                "/;.*UPDATE/i",
                "/;.*INSERT/i",
                "/0x[0-9a-f]+/i",
                "/CONCAT\(/i",
                "/CHAR\(/i",
            ],
            'xss_attempt' => [
                "/<script/i",
                "/<iframe/i",
                "/javascript:/i",
                "/onerror=/i",
                "/onload=/i",
                "/onclick=/i",
                "/<img.*src/i",
                "/alert\(/i",
                "/eval\(/i",
            ],
            'path_traversal' => [
                "/\.\.\//",
                "/\.\.\\\/",
            ],
        ];

        $allInput = json_encode($request->all());
        
        foreach ($suspiciousPatterns as $eventType => $patterns) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $allInput)) {
                    $this->logSecurityEvent($eventType, $request, $pattern, $allInput);
                    break 2; // Stop after first match to avoid duplicate logs
                }
            }
        }
    }

    /**
     * Log security event
     */
    private function logSecurityEvent(string $eventType, Request $request, string $pattern, string $evidence): void
    {
        try {
            DB::table('security_events')->insert([
                'event_type' => $eventType,
                'severity' => 'high',
                'description' => "Potential {$eventType} detected. Pattern: {$pattern}",
                'evidence' => substr($evidence, 0, 1000), // Limit evidence length
                'ip_address' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log security event: ' . $e->getMessage());
        }
    }
}
