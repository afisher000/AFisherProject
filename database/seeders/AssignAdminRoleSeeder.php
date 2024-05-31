<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the 'admin' role
        $adminRole = Role::findByName('admin');

        // Find the user with ID 2
        $user = User::find(1);

        if ($adminRole && $user) {
            // Assign the 'admin' role to the user
            $user->assignRole($adminRole);
        }
    }
}
