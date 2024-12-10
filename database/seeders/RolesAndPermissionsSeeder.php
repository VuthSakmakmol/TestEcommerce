<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']); // Ensures the role is not duplicated
        $user = Role::firstOrCreate(['name' => 'user']);   // Ensures the role is not duplicated

        // Create permissions
        $managePostsPermission = Permission::firstOrCreate(['name' => 'manage posts']); // Avoid duplication
        $editProfilePermission = Permission::firstOrCreate(['name' => 'edit profile']); // Avoid duplication

        // Assign permissions to roles
        $admin->givePermissionTo([$managePostsPermission, $editProfilePermission]);
        $user->givePermissionTo($editProfilePermission);

        $this->command->info('Roles and permissions have been successfully seeded!');
    }
}
