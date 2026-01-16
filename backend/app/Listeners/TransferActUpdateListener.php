<?php

namespace App\Listeners;

use App\Dictionaries\EmailDictionary;
use App\Dictionaries\NotificationTypeDictionary;
use App\Events\TransferActUpdated;
use App\Jobs\EmailSendMessageJob;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransferActUpdateListener
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
    public function handle(TransferActUpdated $event): void
    {
        EmailSendMessageJob::dispatch($event->user->email, 'Акт материального перемещения', EmailDictionary::TRANSFER_ACT_UPDATE_EMAIL)
            ->onConnection('rabbitmq')->onQueue('email');
        $this->notificationService->createNotification($event->user->id, NotificationTypeDictionary::TRANSFER_ACT_UPDATE);
    }
}
