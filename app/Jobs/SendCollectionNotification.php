namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\NotificationService;
use App\Models\CollectionRequest;

class SendCollectionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The collection request instance.
     *
     * @var CollectionRequest
     */
    protected $collectionRequest;

    /**
     * Create a new job instance.
     *
     * @param CollectionRequest $collectionRequest
     * @return void
     */
    public function __construct(CollectionRequest $collectionRequest)
    {
        $this->collectionRequest = $collectionRequest;
    }

    /**
     * Execute the job.
     *
     * @param NotificationService $service
     * @return void
     */
    public function handle(NotificationService $service)
    {
        $service->sendCollectionNotification($this->collectionRequest);
    }
}
