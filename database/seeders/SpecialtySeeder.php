<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            [
                'name' => 'Nội khoa',
                'description' => 'Chuyên điều trị các bệnh lý nội khoa'
            ],
            [
                'name' => 'Ngoại khoa',
                'description' => 'Chuyên điều trị các bệnh lý ngoại khoa'
            ],
            [
                'name' => 'Sản phụ khoa',
                'description' => 'Chuyên về sản khoa và phụ khoa'
            ],
            [
                'name' => 'Nhi khoa',
                'description' => 'Chuyên điều trị bệnh cho trẻ em'
            ],
            [
                'name' => 'Tai mũi họng',
                'description' => 'Chuyên về tai mũi họng'
            ],
            [
                'name' => 'Răng hàm mặt',
                'description' => 'Chuyên về răng hàm mặt'
            ],
            [
                'name' => 'Da liễu',
                'description' => 'Chuyên về da liễu'
            ],
            [
                'name' => 'Mắt',
                'description' => 'Chuyên về mắt'
            ]
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }
    }
}
