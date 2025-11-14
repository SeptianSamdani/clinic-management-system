<?php

// database/seeders/AppointmentSeeder.php
namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        
        $reasons = [
            'Kontrol rutin',
            'Keluhan demam',
            'Check up kesehatan',
            'Konsultasi hasil lab',
            'Keluhan nyeri',
            'Imunisasi',
            'Kontrol gula darah',
            'Kontrol tekanan darah',
        ];

        // Past appointments (completed)
        for ($i = 0; $i < 50; $i++) {
            $appointmentDate = Carbon::now()->subDays(rand(1, 90))->setTime(rand(8, 16), [0, 30][rand(0, 1)]);
            
            Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => $appointmentDate,
                'status' => 'completed',
                'reason' => $reasons[array_rand($reasons)],
            ]);
        }

        // Upcoming appointments
        for ($i = 0; $i < 30; $i++) {
            $appointmentDate = Carbon::now()->addDays(rand(1, 30))->setTime(rand(8, 16), [0, 30][rand(0, 1)]);
            
            Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => $appointmentDate,
                'status' => ['pending', 'confirmed'][array_rand(['pending', 'confirmed'])],
                'reason' => $reasons[array_rand($reasons)],
            ]);
        }

        // Cancelled appointments
        for ($i = 0; $i < 10; $i++) {
            $appointmentDate = Carbon::now()->subDays(rand(1, 60))->setTime(rand(8, 16), [0, 30][rand(0, 1)]);
            
            Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => $appointmentDate,
                'status' => 'cancelled',
                'reason' => $reasons[array_rand($reasons)],
            ]);
        }
    }
}