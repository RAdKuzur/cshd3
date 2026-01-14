<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailService
{
    public function send($email, $text = null, $html = null)
    {
        $transport = Transport::fromDsn(env('MAIL_DSN'))
            ->setUsername(env('MAIL_USERNAME'))
            ->setPassword(env('MAIL_PASSWORD'));

        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from(env('MAIL_FROM_ADDRESS'))
            ->to($email)
            ->subject('Письмо от системы учёта мат. ценностей')
            ->text($text)
            ->html($html);

        try {
            $mailer->send($email);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }
}
