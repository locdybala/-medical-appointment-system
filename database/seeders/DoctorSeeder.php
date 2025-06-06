<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        $specialties = Specialty::all();
        $rooms = Room::all();

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'Bác sĩ ' . $i,
                'email' => 'doctor' . $i . '@example.com',
                'password' => Hash::make('password'),
                'phone' => '012345678' . $i,
                'address' => 'Hà Nội',
                'role' => 'doctor'
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'specialty_id' => $specialties->random()->id,
                'room_id' => $rooms->random()->id,
                'qualification' => 'Thạc sĩ',
                'experience' => rand(5, 20) . ' năm',
                'description' => 'Bác sĩ có kinh nghiệm trong lĩnh vực chuyên môn',
                'is_active' => 1,
                'gender' => 'male',
                'image' => 'https://via.placeholder.com/150',
                'phone' => '012345678' . $i,
                'address' => 'Hà Nội',
                'consultation_fee' => rand(200000, 500000),
            ]);
        }
    }
}
