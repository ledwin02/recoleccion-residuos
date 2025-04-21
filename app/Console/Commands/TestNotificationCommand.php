<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test
                            {phone : Número de teléfono para enviar la notificación}
                            {--template=collection-scheduled : Slug de la plantilla a usar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar el envío de notificaciones WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $service)
    {
        // Validar el número de teléfono
        $phone = $this->argument('phone');
        $validator = Validator::make(['phone' => $phone], [
            'phone' => 'required|regex:/^\+?[1-9]\d{1,14}$/', // Valida un número de teléfono internacional
        ]);

        if ($validator->fails()) {
            $this->error('❌ Número de teléfono no válido.');
            return 1;
        }

        // Crear un objeto de usuario (sin guardar en la base de datos)
        $user = new User([
            'name' => 'Usuario de Prueba',
            'phone' => $phone,
        ]);

        $template = $this->option('template');

        try {
            // Enviar la notificación
            $result = $service->sendTemplateNotification(
                $template,
                $user,
                [
                    'name' => $user->name,
                    'waste_type' => 'Residuos Orgánicos',
                    'date' => now()->format('d/m/Y'),
                    'time' => now()->addHour()->format('H:i')
                ]
            );

            if ($result) {
                $this->info('✅ Notificación enviada exitosamente a ' . $user->phone);
                return 0;
            } else {
                $this->error('❌ Error al enviar notificación a ' . $user->phone);
                return 1;
            }
        } catch (\Exception $e) {
            // Captura de excepciones para un manejo adecuado de errores
            $this->error('❌ Error al enviar la notificación: ' . $e->getMessage());
            return 1;
        }
    }
}
