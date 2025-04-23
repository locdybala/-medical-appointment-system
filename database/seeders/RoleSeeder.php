<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Doctor permissions
            'view doctors',
            'create doctors',
            'edit doctors',
            'delete doctors',
            
            // Patient permissions
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',
            
            // Appointment permissions
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            
            // Specialty permissions
            'view specialties',
            'create specialties',
            'edit specialties',
            'delete specialties',
            
            // Schedule permissions
            'view schedules',
            'create schedules',
            'edit schedules',
            'delete schedules',
            
            // Room permissions
            'view rooms',
            'create rooms',
            'edit rooms',
            'delete rooms',
            
            // Post permissions
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $doctor = Role::create(['name' => 'doctor']);
        $doctor->givePermissionTo([
            'view appointments',
            'edit appointments',
            'view schedules',
            'edit schedules',
            'view patients',
        ]);

        $patient = Role::create(['name' => 'patient']);
        $patient->givePermissionTo([
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
        ]);
    }
} 