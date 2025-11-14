<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForensicController extends Controller
{
    public function showLoginForm()
    {
        // Check if already authenticated
        if (session()->has('forensic_authenticated')) {
            return redirect()->route('forensic.dashboard');
        }
        
        return view('forensic.login');
    }

    public function authenticate(Request $request)
    {
        $password = $request->input('password');
        
        if ($password === 'forensic123') {
            session(['forensic_authenticated' => true]);
            return redirect()->route('forensic.dashboard');
        }
        
        return back()->withErrors(['password' => 'Password salah']);
    }

    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        // Get forensic logs
        $requestLogs = DB::table('request_logs')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $sqlLogs = DB::table('sql_logs')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $auditTrails = DB::table('audit_trails')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $securityEvents = DB::table('security_events')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_requests' => DB::table('request_logs')->whereDate('created_at', $date)->count(),
            'suspicious_queries' => DB::table('sql_logs')
                ->whereDate('created_at', $date)
                ->where(function($query) {
                    $query->where('query', 'like', '%OR%')
                          ->orWhere('query', 'like', '%UNION%')
                          ->orWhere('query', 'like', '%---%');
                })
                ->count(),
            'high_severity_events' => DB::table('security_events')
                ->whereDate('created_at', $date)
                ->whereIn('severity', ['high', 'critical'])
                ->count(),
            'data_modifications' => DB::table('audit_trails')
                ->whereDate('created_at', $date)
                ->whereIn('action', ['update', 'delete'])
                ->count(),
        ];

        return view('forensic.dashboard', compact('requestLogs', 'sqlLogs', 'auditTrails', 'securityEvents', 'stats', 'date'));
    }

    public function requestLogs(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $logs = DB::table('request_logs')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('forensic.request-logs', compact('logs', 'date'));
    }

    public function sqlLogs(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $logs = DB::table('sql_logs')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('forensic.sql-logs', compact('logs', 'date'));
    }

    public function auditTrails(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $logs = DB::table('audit_trails')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('forensic.audit-trails', compact('logs', 'date'));
    }

    public function securityEvents(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $logs = DB::table('security_events')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('forensic.security-events', compact('logs', 'date'));
    }

    public function export(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        $data = [
            'date' => $date,
            'request_logs' => DB::table('request_logs')->whereDate('created_at', $date)->get(),
            'sql_logs' => DB::table('sql_logs')->whereDate('created_at', $date)->get(),
            'audit_trails' => DB::table('audit_trails')->whereDate('created_at', $date)->get(),
            'security_events' => DB::table('security_events')->whereDate('created_at', $date)->get(),
        ];
        
        $filename = "forensic_logs_{$date}.json";
        
        return response()->json($data)
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }

    public function logout()
    {
        session()->forget('forensic_authenticated');
        return redirect()->route('forensic.login');
    }
}