<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlantillasNews extends Seeder
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
                'attachments' => null,
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
            [
                'subject' => 'Promoción exclusiva',
                'body' => '<p>¡Aprovecha nuestra promoción especial! Solo por tiempo limitado, obtén un 20% de descuento en todos nuestros productos. </p><img src="https://example.com/images/promocion.jpg" alt="Promoción Especial">',
                'attachments' => 'https://example.com/files/promocion-detalles.pdf',
                'created_at' => '2024-12-01 10:00:00',
                'updated_at' => '2024-12-01 10:00:00',
            ],
            [
                'subject' => 'Evento de fin de año',
                'body' => '<p>Únete a nosotros en nuestra celebración de fin de año. Habrá actividades, premios y mucho más. ¡No te lo pierdas!</p><img src="https://example.com/images/evento-fin-ano.jpg" alt="Evento de Fin de Año">',
                'attachments' => 'https://example.com/files/evento-invitacion.pdf',
                'created_at' => '2024-12-15 08:30:00',
                'updated_at' => '2024-12-15 08:30:00',
            ],
            [
                'subject' => 'Lanzamiento de producto',
                'body' => '<p>Estamos emocionados de anunciar el lanzamiento de nuestro nuevo producto. Descubre todas sus características innovadoras en nuestro sitio web.</p><img src="https://example.com/images/nuevo-producto.jpg" alt="Nuevo Producto">',
                'attachments' => 'https://example.com/files/producto-detalles.pdf',
                'created_at' => '2024-11-25 09:00:00',
                'updated_at' => '2024-11-25 09:00:00',
            ],
            [
                'subject' => 'Gracias por tu apoyo',
                'body' => '<p>Queremos agradecerte por formar parte de nuestra comunidad. Tu apoyo nos inspira a seguir creciendo y mejorando. </p><img src="https://example.com/images/agradecimiento.jpg" alt="Gracias por tu apoyo">',
                'attachments' => null,
                'created_at' => '2024-11-20 12:00:00',
                'updated_at' => '2024-11-20 12:00:00',
            ],
            [
                'subject' => 'Consejos para sacar el máximo provecho',
                'body' => '<p>Descubre cómo aprovechar al máximo nuestros servicios con estos útiles consejos. </p><img src="https://example.com/images/consejos.jpg" alt="Consejos">',
                'attachments' => 'https://example.com/files/consejos.pdf',
                'created_at' => '2024-11-10 07:45:00',
                'updated_at' => '2024-11-10 07:45:00',
            ],
        ];

        foreach ($news as $new) {
            EmailTemplate::create($new);
        }
    }
}
