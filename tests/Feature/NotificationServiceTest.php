use App\Models\User;
use App\Models\CollectionRequest;
use App\Services\NotificationService;
use Mockery;
use Twilio\Rest\Client;

public function test_send_notification()
{
    // Mock de Twilio
    $twilioMock = Mockery::mock(Client::class);
    $twilioMock->shouldReceive('messages->create')->once();

    // Crear servicio con mock
    $service = new NotificationService();
    $service->setTwilioClient($twilioMock);

    // Datos de prueba
    $user = User::factory()->create(['phone' => '3001234567']);
    $request = CollectionRequest::factory()->create(['user_id' => $user->id]);

    $result = $service->sendCollectionNotification($request);

    $this->assertTrue($result);
}
