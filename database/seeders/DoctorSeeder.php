<?php

// database/seeders/DoctorSeeder.php
namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'license_number' => 'SIP-001-2020',
                'specialization' => 'Penyakit Dalam',
                'experience_years' => 15,
                'bio' => 'Dokter spesialis penyakit dalam dengan pengalaman 15 tahun menangani berbagai kasus medis kompleks.',
            ],
            [
                'license_number' => 'SIP-002-2021',
                'specialization' => 'Anak',
                'experience_years' => 10,
                'bio' => 'Spesialis anak yang berpengalaman dalam menangani kesehatan bayi, anak, dan remaja.',
            ],
            [
                'license_number' => 'SIP-003-2019',
                'specialization' => 'Jantung dan Pembuluh Darah',
                'experience_years' => 12,
                'bio' => 'Ahli kardiologi dengan fokus pada penyakit jantung koroner dan hipertensi.',
            ],
            [
                'license_number' => 'SIP-004-2022',
                'specialization' => 'Kandungan',
                'experience_years' => 8,
                'bio' => 'Spesialis obstetri dan ginekologi untuk kesehatan wanita dan kehamilan.',
            ],
            [
                'license_number' => 'SIP-005-2018',
                'specialization' => 'Bedah Umum',
                'experience_years' => 18,
                'bio' => 'Ahli bedah umum dengan keahlian dalam operasi laparoskopi dan bedah darurat.',
            ],
        ];

        $doctorUsers = User::where('role', 'doctor')->get();

        foreach ($doctorUsers as $index => $user) {
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => $doctors[$index]['license_number'],
                'specialization' => $doctors[$index]['specialization'],
                'experience_years' => $doctors[$index]['experience_years'],
                'bio' => $doctors[$index]['bio'],
            ]);
        }
    }
}