<?php

namespace Database\Seeders; // Add this namespace declaration

use Illuminate\Database\Seeder; // Import the Seeder class
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'manage posts']);
        Permission::create(['name' => 'edit profile']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage posts', 'edit profile']);
        $user->givePermissionTo('edit profile');
    }
}
