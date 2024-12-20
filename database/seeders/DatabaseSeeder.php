<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

    
        $this->call([
            RolsTableSeeder::class,
            UsersTableSeeder::class,
            SettingSeeder::class,
            PlantillasNews::class,
            // FileClients::class,
            // BookingSeeder::class // Si no tienes el DUMP.sql, 
                                   // descomenta esta línea para importar los datos de esta tabla
        ]);
    }
}
