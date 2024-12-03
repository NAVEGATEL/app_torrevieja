<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Eliminar usuarios
        // User::where('name', 'Admin-Pedro')->delete();
        // User::where('name', 'SuperAdmin-Edvard')->delete();

        $users = [
            [
                'name' => 'SuperAdmin-Edvard',
                'rol_id' => 1,
                'email' => 'info@edvardks.com',
                'password' => Hash::make('1997')
            ],
            [
                'name' => 'Admin-rLopez',
                'rol_id' => 2,
                'email' => 'rlopez@navegatel.es',
                'password' => Hash::make('gpt')
            ],
            [
                'name' => 'Admin-Pedro',
                'rol_id' => 2,
                'email' => 'pedro@navegatel.es',
                'password' => Hash::make('bmw2015')
            ],
            [
                'name' => 'Nachito',
                'rol_id' => 3,
                'email' => 'nachito@aragoneses.com',
                'password' => Hash::make('123')
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
