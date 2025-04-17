<?php

namespace App\Services;

use App\Models\CollectionRequest;
use App\Models\User;
use App\Models\NotificationTemplate;
use App\Models\NotificationLog;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    private $twilioClient;

    public function __construct()
    {
        $this->twilioClient = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    /**
     * Envía notificación de recolección programada
     */
    public function sendCollectionNotification(CollectionRequest $request): bool
    {
        try {
            $user = $request->user;
            $wasteType = $request->wasteType->name;
            $date = $request->collection_date->format('d/m/Y');

            $message = $this->buildCollectionMessage($user, $wasteType, $date);

            $this->sendWhatsApp($user->phone, $message);

            // Registrar log exitoso
            NotificationLog::create([
                'user_id' => $user->id,
                'collection_request_id' => $request->id,
                'message' => $message,
                'channel' => 'whatsapp',
                'success' => true
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error enviando notificación: ' . $e->getMessage());

            // Registrar log fallido
            NotificationLog::create([
                'user_id' => $request->user->id ?? null,
                'collection_request_id' => $request->id ?? null,
                'message' => $message ?? 'No se pudo construir el mensaje',
                'channel' => 'whatsapp',
                'success' => false,
                'error' => $e->getMessage(),
                'metadata' => [
                    'exception' => get_class($e),
                    'trace' => $e->getTraceAsString()
                ]
            ]);

            return false;
        }
    }

    /**
     * Envía notificación basada en plantilla
     */
    public function sendTemplateNotification(string $templateSlug, User $user, array $variables): bool
    {
        try {
            $template = NotificationTemplate::where('slug', $templateSlug)->firstOrFail();
            $message = $this->parseTemplate($template->content, $variables);

            $this->sendWhatsApp($user->phone, $message);

            return true;
        } catch (\Exception $e) {
            Log::error('Error enviando notificación plantilla: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Construye el mensaje personalizado
     */
    private function buildCollectionMessage(User $user, string $wasteType, string $date): string
    {
        return sprintf(
            "Hola %s,\n\nTu recolección de %s está programada para el %s.\n\nGracias por contribuir al medio ambiente!",
            $user->name,
            $wasteType,
            $date
        );
    }

    /**
     * Parsea una plantilla con variables
     */
    private function parseTemplate(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $template = str_replace("{{{$key}}}", $value, $template);
        }
        return $template;
    }

    /**
     * Envía mensaje por WhatsApp
     */
    private function sendWhatsApp(string $phone, string $message): void
    {
        $this->twilioClient->messages->create(
            "whatsapp:+57{$phone}", // Formato para Colombia
            [
                "from" => "whatsapp:" . config('services.twilio.whatsapp_number'),
                "body" => $message
            ]
        );
    }
}
