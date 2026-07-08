<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect(config('menu.items'))
            ->pluck('roles')
            ->flatten()
            ->filter()
            ->unique()
            ->values();

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            $email = Str::slug($roleName, '_') . '@local.test';
            $userName = $roleName === 'Super Administrator' ? 'Super Administrator' : "Utilisateur $roleName";

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $userName,
                    'password' => bcrypt('Password123!'),
                ]
            );

            if (! $user->hasRole($roleName)) {
                $user->assignRole($role);
            }
        }
    }
}
