<?php

namespace App\Jobs;

use App\Models\CollectionRequest;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $collectionRequest;

    public function __construct(CollectionRequest $collectionRequest)
    {
        $this->collectionRequest = $collectionRequest;
    }

    public function handle(WhatsAppService $whatsappService)
    {
        $whatsappService->sendCollectionNotification($this->collectionRequest);
    }
}
