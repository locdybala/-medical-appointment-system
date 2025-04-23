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
            $schedule = Schedule::where('doctor_id', $doctor->id)
                ->where('is_available', true)
                ->inRandomOrder()
                ->first();

            if ($schedule) {
                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'schedule_id' => $schedule->id,
                    'appointment_date' => $schedule->date,
                    'appointment_time' => $schedule->start_time,
                    'fee' => rand(100000, 500000),
                    'is_paid' => rand(0, 1),
                    'notes' => 'Ghi chú cho lịch hẹn ' . $patient->name,
                ]);

                // Cập nhật trạng thái lịch
                $schedule->update(['is_available' => false]);
            }
        }
    }
}
