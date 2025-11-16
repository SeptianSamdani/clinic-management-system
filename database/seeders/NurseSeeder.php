<?php

// database/seeders/NurseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Nurse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NurseSeeder extends Seeder
{
    public function run(): void
    {
        // Nurse 1: Siti
        $siti = User::create([
            'name' => 'Siti Nurhaliza, A.Md.Kep',
            'email' => 'siti.perawat@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'nurse',
            'phone' => '081234567900',
            'address' => 'Jl. Perawat No. 5, Jakarta',
        ]);

        Nurse::create([
            'user_id' => $siti->id,
            'nurse_number' => 'NRS' . date('Y') . '001',
            'license_number' => 'STR-PER-001-2024',
            'shift' => 'pagi',
        ]);

        // Nurse 2: Ani
        $ani = User::create([
            'name' => 'Ani Yudhoyono, A.Md.Kep',
            'email' => 'ani.perawat@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'nurse',
            'phone' => '081234567901',
            'address' => 'Jl. Perawat No. 10, Jakarta',
        ]);

        Nurse::create([
            'user_id' => $ani->id,
            'nurse_number' => 'NRS' . date('Y') . '002',
            'license_number' => 'STR-PER-002-2024',
            'shift' => 'siang',
        ]);
    }
}