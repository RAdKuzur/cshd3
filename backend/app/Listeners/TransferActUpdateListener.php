<?php

namespace App\Listeners;

use App\Dictionaries\EmailDictionary;
use App\Dictionaries\NotificationTypeDictionary;
use App\Events\TransferActUpdated;
use App\Helpers\UrlHelper;
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
        $url = UrlHelper::createUrlFromSearch('transfer-acts', $event->id);
        $messageType = EmailDictionary::TRANSFER_ACT_UPDATE_EMAIL;
        EmailSendMessageJob::dispatch($event->user->email, 'Акт материального перемещения', EmailDictionary::message($messageType, $url))
            ->onConnection('rabbitmq')->onQueue('email');
        $this->notificationService->createNotification($event->user->id, NotificationTypeDictionary::TRANSFER_ACT_UPDATE);
    }
}
