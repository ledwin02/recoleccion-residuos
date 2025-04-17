<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\NotificationService;

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
        $user = new User([
            'name' => 'Usuario de Prueba',
            'phone' => $this->argument('phone')
        ]);

        $template = $this->option('template');

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
        } else {
            $this->error('❌ Error al enviar notificación a ' . $user->phone);
        }

        return $result ? 0 : 1;
    }
}
