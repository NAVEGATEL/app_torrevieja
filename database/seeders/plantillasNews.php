<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmailTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $news = [
            [
                'subject' => 'Bienvenida',
                'body' => '<p>Hola, gracias por unirte a nuestra comunidad. Estamos emocionados de tenerte con nosotros.</p>',
                'attachments' => null, // Si tienes rutas de archivos de ejemplo, las puedes agregar aquí.
                'created_at' => '1997-02-08 05:52:13',
                'updated_at' => '1997-02-08 05:52:13',
            ],
            [
                'subject' => 'Actualización de servicios',
                'body' => '<p>Hemos actualizado nuestros servicios para ofrecerte una mejor experiencia.</p>',
                'attachments' => null,
                'created_at' => '1997-02-08 05:52:13',
                'updated_at' => '1997-02-08 05:52:13',
            ],
        ];

        foreach ($news as $new) {
            EmailTemplate::create($new);
        }
    }
}
