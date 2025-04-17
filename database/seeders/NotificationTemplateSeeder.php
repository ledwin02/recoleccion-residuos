<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationTemplate::create([
            'slug' => 'collection-scheduled',
            'name' => 'Recolección Programada',
            'content' => "Hola {{name}},\n\nTu recolección de {{waste_type}} está programada para el {{date}}.\n\nGracias por contribuir al medio ambiente!",
            'channel' => 'whatsapp'
        ]);

        // Agrega más plantillas según necesites
        NotificationTemplate::create([
            'slug' => 'collection-reminder',
            'name' => 'Recordatorio de Recolección',
            'content' => "Hola {{name}},\n\nRecordatorio: Tu recolección de {{waste_type}} es mañana a las {{time}}.\n\nPor favor ten todo listo.",
            'channel' => 'whatsapp'
        ]);

        NotificationTemplate::create([
            'slug' => 'collection-completed',
            'name' => 'Recolección Completada',
            'content' => "Hola {{name}},\n\nHemos completado la recolección de tus residuos. Has ganado {{points}} puntos.\n\n¡Gracias por reciclar!",
            'channel' => 'whatsapp'
        ]);
    }
}
