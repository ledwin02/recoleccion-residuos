// app/Services/WhatsAppService.php

namespace App\Services;

use Twilio\Rest\Client;
use App\Models\CollectionRequest;

class WhatsAppService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    public function sendCollectionNotification(CollectionRequest $request)
    {
        $this->twilio->messages->create(
            "whatsapp:+57{$request->user->phone}",
            [
                "from" => env('TWILIO_WHATSAPP_FROM'),
                "body" => "Hola {$request->user->name}, tu recolección de {$request->wasteType->name} está programada para {$request->collection_date}. Turno: #123"
            ]
        );
    }
}
