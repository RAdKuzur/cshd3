<?php

namespace App\Listeners;

use App\Dictionaries\NotificationTypeDictionary;
use App\Events\TransferActCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TransferActListener
{
    /**
     * Create the event listener.
     */
    private NotificationService $notificationService;
    public function __construct(
        NotificationService $notificationService
    )
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(TransferActCreated $event): void
    {
        $this->notificationService->createNotification($event->user->id, NotificationTypeDictionary::TRANSFER_ACT);
    }
}
