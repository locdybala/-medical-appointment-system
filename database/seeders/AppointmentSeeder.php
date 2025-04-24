<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        foreach ($patients as $patient) {
            $doctor = $doctors->random();
            $date = now()->addDays(rand(1, 30));

            // Tạo lịch hẹn
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => $date->format('Y-m-d'),
                'appointment_time' => '08:00:00',
                'status' => ['pending', 'approved', 'completed'][rand(0, 2)],
                'symptoms' => 'Triệu chứng của bệnh nhân ' . $patient->name,
                'fee' => rand(100000, 500000),
                'is_paid' => rand(0, 1),
                'reason' => null,
                'notes' => 'Ghi chú cho lịch hẹn ' . $patient->name,
                'prescription' => null,
                'diagnosis' => null
            ]);
        }
    }
}
