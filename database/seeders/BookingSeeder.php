<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('database/seeders/nauticajsonbooking.json');
        $booking = json_decode(File::get($path), true);

        foreach ($booking as $book) {
            // Reemplazar valores vacíos para campos datetime con NULL
            $book['date_event'] = $book['date_event'] ?: null;
            $book['date_prebooking'] = $book['date_prebooking'] ?: null;
            $book['date_booking'] = $book['date_booking'] ?: null;
            $book['date_modified'] = $book['date_modified'] ?: null;
            $book['date_enjoyed'] = $book['date_enjoyed'] ?: null;
            $book['created_at'] = $book['created_at'] ?: null;
            $book['updated_at'] = $book['updated_at'] ?: null;

            // Crear el registro en la base de datos
            Booking::create($book);
        }
    }
}
