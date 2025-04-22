<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo lịch làm việc cho bác sĩ 1
        $startDate = Carbon::now()->startOfWeek();
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            if ($date->isWeekday()) { // Chỉ tạo lịch từ thứ 2 đến thứ 6
                Schedule::create([
                    'doctor_id' => 1,
                    'date' => $date,
                    'start_time' => '08:00:00',
                    'end_time' => '12:00:00',
                    'is_available' => true,
                ]);

                Schedule::create([
                    'doctor_id' => 1,
                    'date' => $date,
                    'start_time' => '13:00:00',
                    'end_time' => '17:00:00',
                    'is_available' => true,
                ]);
            }
        }

        // Tạo lịch làm việc cho bác sĩ 2
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            if ($date->isWeekday()) {
                Schedule::create([
                    'doctor_id' => 2,
                    'date' => $date,
                    'start_time' => '08:00:00',
                    'end_time' => '12:00:00',
                    'is_available' => true,
                ]);

                Schedule::create([
                    'doctor_id' => 2,
                    'date' => $date,
                    'start_time' => '13:00:00',
                    'end_time' => '17:00:00',
                    'is_available' => true,
                ]);
            }
        }
    }
}
