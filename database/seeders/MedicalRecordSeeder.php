<?php

// database/seeders/MedicalRecordSeeder.php
namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        $complaints = [
            'Demam tinggi sejak 3 hari yang lalu',
            'Batuk berdahak dan pilek',
            'Sakit kepala berkepanjangan',
            'Nyeri dada sebelah kiri',
            'Mual dan muntah',
            'Diare akut',
            'Nyeri perut bagian atas',
            'Sesak napas',
            'Pusing dan lemas',
            'Nyeri sendi lutut',
        ];

        $diagnoses = [
            'ISPA (Infeksi Saluran Pernapasan Atas)',
            'Gastritis akut',
            'Hipertensi grade 1',
            'Diabetes Melitus tipe 2',
            'Migrain',
            'Tension headache',
            'Diare akut',
            'Dispepsia',
            'Anemia ringan',
            'Osteoarthritis',
        ];

        $treatments = [
            'Istirahat cukup, minum air putih minimal 2L/hari',
            'Kompres hangat, hindari makanan pedas',
            'Diet rendah garam, olahraga teratur',
            'Diet rendah gula, kontrol gula darah rutin',
            'Hindari stress, istirahat di ruangan gelap',
            'Minum oralit, hindari makanan berminyak',
            'Makan teratur, hindari kopi dan alkohol',
            'Istirahat cukup, konsumsi makanan bergizi',
        ];

        $prescriptions = [
            'Paracetamol 500mg 3x1, Amoxicillin 500mg 3x1',
            'Omeprazole 20mg 1x1 sebelum makan, Antasida 3x1',
            'Amlodipine 5mg 1x1 pagi hari',
            'Metformin 500mg 2x1 setelah makan',
            'Ibuprofen 400mg 3x1 bila perlu',
            'Oralit, Zinc 20mg 1x1',
            'Vitamin B Complex 1x1',
            'Asam folat, Vitamin C 1x1',
        ];

        // IMPORTANT: Assign patients to specific doctors
        // Doctor 1 (Budi Santoso) gets patients 1-10
        // Doctor 2 (Sarah Wijaya) gets patients 11-20
        // Doctor 3 (Ahmad Fauzi) gets patients 21-30
        // etc.

        $recordId = 1;
        foreach ($doctors as $doctorIndex => $doctor) {
            // Each doctor gets 10 patients
            $startPatient = ($doctorIndex * 10);
            $endPatient = $startPatient + 10;
            
            $doctorPatients = $patients->slice($startPatient, 10);
            
            foreach ($doctorPatients as $patient) {
                // Create 1-3 records per patient
                $numRecords = rand(1, 3);
                
                for ($i = 0; $i < $numRecords; $i++) {
                    $visitDate = Carbon::now()->subDays(rand(1, 365));

                    MedicalRecord::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'visit_date' => $visitDate,
                        'complaint' => $complaints[array_rand($complaints)],
                        'diagnosis' => $diagnoses[array_rand($diagnoses)],
                        'treatment' => $treatments[array_rand($treatments)],
                        'prescription' => $prescriptions[array_rand($prescriptions)],
                        'notes' => 'Pasien kooperatif. Follow up 1 minggu.',
                    ]);
                }
            }
        }

        // Add some cross-doctor records (konsultasi antar dokter)
        // This is NORMAL behavior
        for ($i = 0; $i < 5; $i++) {
            MedicalRecord::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'visit_date' => Carbon::now()->subDays(rand(1, 30)),
                'complaint' => $complaints[array_rand($complaints)],
                'diagnosis' => 'Konsultasi kedua/rujukan',
                'treatment' => $treatments[array_rand($treatments)],
                'prescription' => $prescriptions[array_rand($prescriptions)],
                'notes' => 'Pasien rujukan dari dokter lain.',
            ]);
        }
    }
}