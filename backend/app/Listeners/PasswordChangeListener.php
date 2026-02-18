<?php

namespace App\Listeners;

use App\Dictionaries\EmailDictionary;
use App\Events\PasswordChanged;
use App\Helpers\UrlHelper;
use App\Jobs\EmailSendMessageJob;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\URL;

class PasswordChangeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordChanged $event): void
    {
        $url = UrlHelper::urlWithoutApi(URL::temporarySignedRoute('change-password', now()->addHour()));
        $messageType = EmailDictionary::CHANGE_PASSWORD;
        EmailSendMessageJob::dispatch($event->email, 'Сброс пароля', EmailDictionary::message($messageType, $url))
            ->onConnection('rabbitmq')->onQueue('email');
    }
}
