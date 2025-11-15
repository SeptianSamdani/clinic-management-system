<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class SimulateBalancedAttack extends Command
{
    protected $signature = 'forensic:simulate-balanced-attack';
    protected $description = 'Simulate simple insider threat - doctor accessing other doctors records';

    public function handle()
    {
        $this->info('🎭 Starting Balanced Insider Threat Simulation...');
        $this->newLine();

        // Get Dr. Budi (Doctor 1)
        $budi = User::where('email', 'budi.santoso@klinik.com')->first();
        if (!$budi) {
            $this->error('❌ Dr. Budi not found. Run seeders first.');
            return 1;
        }

        $budiDoctor = $budi->doctor;
        
        // Get his records (should be patients 1-10)
        $myRecords = MedicalRecord::where('doctor_id', $budiDoctor->id)->get();
        
        // Get other doctors' records (patients 11-50)
        $otherRecords = MedicalRecord::where('doctor_id', '!=', $budiDoctor->id)
                                     ->inRandomOrder()
                                     ->limit(5)
                                     ->get();

        $this->info("👤 Attacker: {$budi->name}");
        $this->info("📊 His legitimate records: {$myRecords->count()}");
        $this->info("🎯 Target records (other doctors): {$otherRecords->count()}");
        $this->newLine();

        $baseTime = Carbon::now()->subHours(1);

        // PHASE 1: Normal access (his own patients)
        $this->info('✅ PHASE 1: Normal Access (Baseline Behavior)');
        foreach ($myRecords->take(3) as $index => $record) {
            $this->simulateAccess($budi, $record->id, $baseTime->copy()->addMinutes($index * 5), true);
            $patient = $record->patient;
            $this->line("   ✓ Accessed own patient: {$patient->user->name} (Record #{$record->id})");
        }
        $this->newLine();

        // PHASE 2: Unauthorized access (other doctors' patients)
        $this->info('⚠️  PHASE 2: Unauthorized Access');
        sleep(1);
        
        foreach ($otherRecords as $index => $record) {
            $this->simulateAccess($budi, $record->id, $baseTime->copy()->addMinutes(20 + ($index * 2)), false);
            $patient = $record->patient;
            $ownerDoctor = $record->doctor;
            $this->warn("   🚨 Accessed record #{$record->id} - Patient: {$patient->user->name} (Owner: Dr. {$ownerDoctor->user->name})");
            
            // Simulate rapid re-access (data copying)
            if ($index == 2) {
                for ($i = 0; $i < 3; $i++) {
                    $this->simulateAccess($budi, $record->id, $baseTime->copy()->addMinutes(25 + ($i * 0.5)), false);
                }
                $this->warn("   💾 Rapid repeated access detected (possible data exfiltration)");
            }
        }
        $this->newLine();

        $this->info('✅ Attack Simulation Complete!');
        $this->newLine();
        $this->info('🔍 Investigation Commands:');
        $this->line('   php artisan tinker');
        $this->line('   >>> DB::table(\'security_events\')->where(\'event_type\', \'unauthorized_medical_record_access\')->get();');
        $this->line('   >>> DB::table(\'audit_trails\')->where(\'action\', \'unauthorized_view\')->get();');

        return 0;
    }

    private function simulateAccess($user, $recordId, $timestamp, $isAuthorized)
    {
        // Log request
        DB::table('request_logs')->insert([
            'ip_address' => '192.168.1.100',
            'method' => 'GET',
            'url' => url("/doctor/medical-records/{$recordId}"),
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
            'user_id' => $user->id,
            'request_body' => null,
            'response_code' => 200,
            'created_at' => $timestamp,
        ]);

        // This will be automatically logged by the controller when accessed
        // But we simulate it here for the attack timeline
        if (!$isAuthorized) {
            $record = MedicalRecord::find($recordId);
            
            DB::table('security_events')->insert([
                'event_type' => 'unauthorized_medical_record_access',
                'severity' => 'high',
                'description' => "Doctor {$user->name} accessed medical record #{$recordId} not owned by them",
                'evidence' => json_encode([
                    'record_id' => $recordId,
                    'patient_id' => $record->patient_id,
                    'record_owner' => $record->doctor_id,
                    'accessor' => $user->doctor->id,
                ]),
                'ip_address' => '192.168.1.100',
                'user_id' => $user->id,
                'created_at' => $timestamp,
            ]);
        }
    }
}