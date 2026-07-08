<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create role
        $role = Role::firstOrCreate(['name' => 'Super Administrator']);

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@local.test'
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('Admin123!')
        ]);

        // Assign role
        $admin->assignRole($role);
    }
}
