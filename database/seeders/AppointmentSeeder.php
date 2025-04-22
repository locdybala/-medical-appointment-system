<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        foreach ($patients as $patient) {
            $doctor = $doctors->random();
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => now()->addDays(rand(1, 30)),
                'appointment_time' => now()->addHours(rand(1, 12))->format('H:i'),
                'fee' => rand(100000, 500000),
                'is_paid' => rand(0, 1),
                'notes' => 'Ghi chú cho lịch hẹn ' . $patient->name,
            ]);
        }
    }
}
