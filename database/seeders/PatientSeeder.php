<?php

// database/seeders/PatientSeeder.php
namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patientUsers = User::where('role', 'patient')->get();
        $bloodTypes = ['A', 'B', 'AB', 'O', 'Unknown'];
        $genders = ['male', 'female'];
        
        $medicalHistories = [
            'Tidak ada riwayat penyakit serius',
            'Riwayat hipertensi',
            'Riwayat diabetes melitus tipe 2',
            'Riwayat asma',
            'Riwayat penyakit jantung keluarga',
            'Pernah operasi usus buntu',
            'Riwayat stroke ringan',
            'Gastritis kronis',
            'Tidak ada',
        ];

        $allergies = [
            'Tidak ada alergi',
            'Alergi seafood',
            'Alergi obat penisilin',
            'Alergi debu',
            'Alergi dingin',
            'Alergi makanan tertentu',
            'Tidak ada',
        ];

        foreach ($patientUsers as $index => $user) {
            $birthYear = rand(1950, 2010);
            $birthMonth = rand(1, 12);
            $birthDay = rand(1, 28);

            Patient::create([
                'user_id' => $user->id,
                'patient_number' => 'P' . date('Y') . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'nik' => '31' . rand(10, 99) . sprintf('%012d', $index + 1),
                'birth_date' => Carbon::create($birthYear, $birthMonth, $birthDay),
                'gender' => $genders[array_rand($genders)],
                'blood_type' => $bloodTypes[array_rand($bloodTypes)],
                'medical_history' => $medicalHistories[array_rand($medicalHistories)],
                'allergies' => $allergies[array_rand($allergies)],
            ]);
        }
    }
}