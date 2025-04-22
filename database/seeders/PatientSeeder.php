<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => 'Bệnh nhân ' . $i,
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('password'),
                'phone' => '098765432' . $i,
                'address' => 'Hà Nội',
                'role' => 'patient'
            ]);

            Patient::create([
                'user_id' => $user->id,
                'name' => 'Bệnh nhân ' . $i,
                'gender' => rand(0, 1) ? 'male' : 'female',
                'date_of_birth' => now()->subYears(rand(18, 60)),
                'blood_group' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'][rand(0, 7)],
                'medical_history' => 'Không có tiền sử bệnh đặc biệt',
                'allergies' => 'Không có dị ứng'
            ]);
        }
    }
}
