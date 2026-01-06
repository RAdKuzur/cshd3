<?php

namespace App\Listeners;

use App\Dictionaries\NotificationTypeDictionary;
use App\Events\TransferActConfirmChanged;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransferActConfirmListener
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
    public function handle(TransferActConfirmChanged $event): void
    {
        $this->notificationService->createNotification($event->user->id, NotificationTypeDictionary::TRANSFER_ACT_CONFIRM);
    }
}
