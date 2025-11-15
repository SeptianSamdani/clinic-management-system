<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class InvestigateUnauthorizedAccess extends Command
{
    protected $signature = 'forensic:investigate {--doctor= : Doctor email to investigate}';
    protected $description = 'Investigate unauthorized medical record access';

    public function handle()
    {
        $this->info('🔍 FORENSIC INVESTIGATION: Unauthorized Access');
        $this->info('=' . str_repeat('=', 60));
        $this->newLine();

        $doctorEmail = $this->option('doctor') ?? 'budi.santoso@klinik.com';
        $doctor = User::where('email', $doctorEmail)->first();

        if (!$doctor) {
            $this->error('Doctor not found!');
            return 1;
        }

        $this->info("Investigating: {$doctor->name} ({$doctor->email})");
        $this->newLine();

        // 1. Find unauthorized access
        $this->info('1. UNAUTHORIZED ACCESS EVENTS:');
        $this->line(str_repeat('-', 60));
        
        $unauthorizedAccess = DB::table('security_events')
            ->where('user_id', $doctor->id)
            ->where('event_type', 'unauthorized_medical_record_access')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($unauthorizedAccess->isEmpty()) {
            $this->info('   ✓ No unauthorized access detected');
        } else {
            $this->error("   ⚠️  Found {$unauthorizedAccess->count()} unauthorized access events!");
            foreach ($unauthorizedAccess as $event) {
                $evidence = json_decode($event->evidence);
                $this->line("   • {$event->created_at}: Record #{$evidence->record_id} (Patient #{$evidence->patient_id})");
            }
        }
        $this->newLine();

        // 2. Access timeline
        $this->info('2. ACCESS TIMELINE (Last 24 hours):');
        $this->line(str_repeat('-', 60));
        
        $timeline = DB::table('request_logs')
            ->where('user_id', $doctor->id)
            ->where('url', 'like', '%medical-records/%')
            ->where('created_at', '>=', now()->subDay())
            ->orderBy('created_at')
            ->get();

        foreach ($timeline as $log) {
            preg_match('/medical-records\/(\d+)/', $log->url, $matches);
            $recordId = $matches[1] ?? 'unknown';
            $this->line("   {$log->created_at}: Record #{$recordId} - {$log->method} {$log->response_code}");
        }
        $this->newLine();

        // 3. Pattern analysis
        $this->info('3. PATTERN ANALYSIS:');
        $this->line(str_repeat('-', 60));
        
        $accessCount = $timeline->count();
        $unauthorizedCount = $unauthorizedAccess->count();
        $percentage = $accessCount > 0 ? round(($unauthorizedCount / $accessCount) * 100, 2) : 0;
        
        $this->line("   Total Access: {$accessCount}");
        $this->line("   Unauthorized: {$unauthorizedCount}");
        $this->line("   Violation Rate: {$percentage}%");
        
        if ($percentage > 20) {
            $this->error("   ⚠️  HIGH RISK: More than 20% unauthorized access!");
        }
        $this->newLine();

        // 4. Recommendations
        $this->info('4. RECOMMENDATIONS:');
        $this->line(str_repeat('-', 60));
        if ($unauthorizedCount > 0) {
            $this->line("   • Suspend doctor's account immediately");
            $this->line("   • Notify affected patients");
            $this->line("   • Review all accessed records");
            $this->line("   • Conduct security audit");
            $this->line("   • Implement proper access control");
        } else {
            $this->line("   • No immediate action required");
            $this->line("   • Continue monitoring");
        }
        $this->newLine();

        $this->info('=' . str_repeat('=', 60));
        $this->info('END OF INVESTIGATION');

        return 0;
    }
}