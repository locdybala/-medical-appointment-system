<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Quản trị viên hệ thống'
        ]);

        $doctor = Role::create([
            'name' => 'Doctor',
            'slug' => 'doctor',
            'description' => 'Bác sĩ'
        ]);

        $staff = Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => 'Nhân viên'
        ]);

        // Create permissions
        $permissions = [
            'manage_doctors' => 'Quản lý bác sĩ',
            'manage_patients' => 'Quản lý bệnh nhân',
            'manage_appointments' => 'Quản lý lịch hẹn',
            'manage_schedules' => 'Quản lý lịch khám',
            'manage_rooms' => 'Quản lý phòng khám',
            'manage_specialties' => 'Quản lý chuyên khoa',
            'manage_posts' => 'Quản lý bài viết',
            'manage_categories' => 'Quản lý danh mục',
            'view_appointments' => 'Xem lịch hẹn',
            'manage_own_schedule' => 'Quản lý lịch cá nhân'
        ];

        foreach ($permissions as $slug => $name) {
            Permission::create([
                'name' => $name,
                'slug' => $slug
            ]);
        }

        // Assign all permissions to admin
        $admin->permissions()->attach(Permission::all());

        // Assign permissions to doctor
        $doctor->permissions()->attach(Permission::whereIn('slug', [
            'view_appointments',
            'manage_own_schedule'
        ])->get());

        // Assign permissions to staff
        $staff->permissions()->attach(Permission::whereIn('slug', [
            'manage_patients',
            'manage_appointments',
            'view_appointments'
        ])->get());
    }
} 