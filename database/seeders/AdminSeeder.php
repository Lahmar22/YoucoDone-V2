<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@youcodone.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'), 
            ]
        );

        
        $admin->assignRole($adminRole);
    }
}