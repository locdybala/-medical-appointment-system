<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Phòng khám 101',
                'description' => 'Phòng khám đa khoa tầng 1',
                'floor' => 'Tầng 1',
                'capacity' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 102',
                'description' => 'Phòng khám nhi tầng 1',
                'floor' => 'Tầng 1',
                'capacity' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 201',
                'description' => 'Phòng khám tim mạch tầng 2',
                'floor' => 'Tầng 2',
                'capacity' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 202',
                'description' => 'Phòng khám thần kinh tầng 2',
                'floor' => 'Tầng 2',
                'capacity' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 301',
                'description' => 'Phòng khám nội tổng quát tầng 3',
                'floor' => 'Tầng 3',
                'capacity' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 302',
                'description' => 'Phòng khám tai mũi họng tầng 3',
                'floor' => 'Tầng 3',
                'capacity' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 401',
                'description' => 'Phòng khám da liễu tầng 4',
                'floor' => 'Tầng 4',
                'capacity' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng khám 402',
                'description' => 'Phòng khám mắt tầng 4',
                'floor' => 'Tầng 4',
                'capacity' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng cấp cứu 101',
                'description' => 'Phòng cấp cứu tầng 1',
                'floor' => 'Tầng 1',
                'capacity' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Phòng tiểu phẫu 201',
                'description' => 'Phòng tiểu phẫu tầng 2',
                'floor' => 'Tầng 2',
                'capacity' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
