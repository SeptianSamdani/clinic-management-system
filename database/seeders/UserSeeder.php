<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Kesehatan No. 1, Jakarta',
        ]);

        // Doctor Users
        $doctors = [
            [
                'name' => 'Dr. Budi Santoso, Sp.PD',
                'email' => 'budi.santoso@klinik.com',
                'phone' => '081234567891',
                'address' => 'Jl. Dokter No. 10, Jakarta',
            ],
            [
                'name' => 'Dr. Sarah Wijaya, Sp.A',
                'email' => 'sarah.wijaya@klinik.com',
                'phone' => '081234567892',
                'address' => 'Jl. Anak No. 5, Jakarta',
            ],
            [
                'name' => 'Dr. Ahmad Fauzi, Sp.JP',
                'email' => 'ahmad.fauzi@klinik.com',
                'phone' => '081234567893',
                'address' => 'Jl. Jantung No. 7, Jakarta',
            ],
            [
                'name' => 'Dr. Linda Kusuma, Sp.OG',
                'email' => 'linda.kusuma@klinik.com',
                'phone' => '081234567894',
                'address' => 'Jl. Kandungan No. 3, Jakarta',
            ],
            [
                'name' => 'Dr. Rudi Hermawan, Sp.B',
                'email' => 'rudi.hermawan@klinik.com',
                'phone' => '081234567895',
                'address' => 'Jl. Bedah No. 12, Jakarta',
            ],
        ];

        foreach ($doctors as $doctor) {
            User::create([
                'name' => $doctor['name'],
                'email' => $doctor['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => $doctor['phone'],
                'address' => $doctor['address'],
            ]);
        }

        // Patient Users (50 patients)
        $firstNames = ['Andi', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hana', 'Indra', 'Joko', 
                       'Kartika', 'Lina', 'Made', 'Nina', 'Omar', 'Putri', 'Qori', 'Rina', 'Sari', 'Tono',
                       'Umar', 'Vina', 'Wulan', 'Yanto', 'Zahra', 'Agus', 'Bunga', 'Cahya', 'Dian', 'Elsa'];
        $lastNames = ['Pratama', 'Kusuma', 'Wijaya', 'Santoso', 'Putri', 'Saputra', 'Wati', 'Lestari', 'Hakim', 'Permana',
                      'Suharto', 'Hidayat', 'Setiawan', 'Rahayu', 'Nugroho', 'Dewanto', 'Maharani', 'Gunawan', 'Firmansyah', 'Anggraini'];

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            
            User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . $i . '@email.com',
                'password' => Hash::make('password'),
                'role' => 'patient',
                'phone' => '0812' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'address' => 'Jl. Pasien No. ' . $i . ', ' . ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'][array_rand(['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'])],
            ]);
        }
    }
}
