<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crée un rôle admin s'il n'existe pas
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crée l'utilisateur admin
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
            ]
        );

        // Assigne le rôle admin
        if (!$user->hasRole('admin')) {
            $user->assignRole($adminRole);
        }
    }
}
