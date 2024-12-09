<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoleSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(1); // Replace with your user ID

        if ($user) {
            // Ensure the 'admin' role exists
            $role = Role::firstOrCreate(['name' => 'admin']);

            // Manually assign the role with the model_type
            $user->roles()->attach($role->id, [
                'model_type' => 'App\\Models\\User'
            ]);

            // Alternatively, use Spatie's built-in method (ensure the package is properly configured)
            // $user->assignRole('admin');
        } else {
            $this->command->error('User with ID 1 not found!');
        }
    }
}
