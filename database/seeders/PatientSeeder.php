<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Patient::create([
                'name' => 'Bệnh nhân ' . $i,
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('password'),
                'phone' => '098765432' . $i,
                'address' => 'Hà Nội',
                'date_of_birth' => now()->subYears(rand(18, 60)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'blood_type' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'][rand(0, 7)],
                'is_active' => true
            ]);
        }
    }
}
