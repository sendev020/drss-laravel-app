<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        $roles = ['admin', 'user', 'secretaire', 'directeur'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Créer les utilisateurs et leur attribuer un rôle
        $users = [
            [
                'name' => 'Saliou SENE',
                'email' => 'sendev020@gmail.com',
                'password' => 'sendev./@2025',
                'role' => 'admin'
            ],
            [
                'name' => 'Personnel DRS',
                'email' => 'personnel@drs.com',
                'password' => 'drs@2025',
                'role' => 'user'
            ],
            [
                'name' => 'Secrétaire',
                'email' => 'secretaire@drs.com',
                'password' => 'secret123',
                'role' => 'secretaire'
            ],
            [
                'name' => 'Directeur',
                'email' => 'yeri2203@yahoo.fr',
                'password' => 'direc@t123',
                'role' => 'directeur'
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );
            $user->assignRole($data['role']);
        }
    }
}
