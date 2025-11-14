<?php

// ==========================================
// app/Http/Middleware/SqlQueryLogger.php
// ==========================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SqlQueryLogger
{
    /**
     * Handle an incoming request and log all SQL queries.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Enable query logging
        DB::enableQueryLog();
        
        $response = $next($request);
        
        // Get all queries executed during this request
        $queries = DB::getQueryLog();
        
        // Log each query
        foreach ($queries as $query) {
            try {
                $executionTime = $query['time'] ?? 0;
                
                DB::table('sql_logs')->insert([
                    'query' => $query['query'],
                    'bindings' => json_encode($query['bindings']),
                    'execution_time' => $executionTime,
                    'user_id' => auth()->id(),
                    'ip_address' => $request->ip(),
                    'created_at' => now(),
                ]);
                
                // Detect suspicious SQL patterns
                $this->detectSuspiciousQuery($query['query'], $request);
                
            } catch (\Exception $e) {
                Log::error('Failed to log SQL query: ' . $e->getMessage());
            }
        }
        
        return $response;
    }

    /**
     * Detect suspicious SQL query patterns
     */
    private function detectSuspiciousQuery(string $query, Request $request): void
    {
        $suspiciousPatterns = [
            '/DROP\s+TABLE/i' => 'drop_table_attempt',
            '/DELETE\s+FROM\s+\w+\s*;/i' => 'mass_delete_attempt',
            '/UPDATE\s+\w+\s+SET.*WHERE.*OR.*1.*=.*1/i' => 'sql_injection_update',
            '/UNION\s+SELECT/i' => 'union_based_injection',
            "/';.*--/i" => 'comment_based_injection',
            '/0x[0-9a-f]+/i' => 'hex_encoded_injection',
        ];

        foreach ($suspiciousPatterns as $pattern => $eventType) {
            if (preg_match($pattern, $query)) {
                try {
                    DB::table('security_events')->insert([
                        'event_type' => $eventType,
                        'severity' => 'critical',
                        'description' => "Suspicious SQL query detected: {$eventType}",
                        'evidence' => substr($query, 0, 1000),
                        'ip_address' => $request->ip(),
                        'user_id' => auth()->id(),
                        'created_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to log suspicious query: ' . $e->getMessage());
                }
                break;
            }
        }
    }
}