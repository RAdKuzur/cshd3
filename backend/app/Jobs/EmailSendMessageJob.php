<?php

namespace App\Jobs;

use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class EmailSendMessageJob implements ShouldQueue
{
    use Queueable;

    private $email;
    private $text;
    private $html;
    /**
     * Create a new job instance.
     */
    public function __construct(
        $email,
        $text,
        $html
    )
    {
        $this->email = $email;
        $this->text = $text;
        $this->html = $html;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        (new EmailService())->send($this->email, $this->text, $this->html);
    }
}
