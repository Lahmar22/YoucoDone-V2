<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

       
        Permission::create(['name' => 'manage restaurants']); 
        Permission::create(['name' => 'place orders']);       
        Permission::create(['name' => 'access dashboard']);   
        Permission::create(['name' => 'delete users']);      

        
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        
        $restaurateur = Role::create(['name' => 'restaurateur']);
        $restaurateur->givePermissionTo('manage restaurants');

        
        $client = Role::create(['name' => 'client']);
        $client->givePermissionTo('place orders');
    }
}