<?php

namespace App\Console\Commands;

use App\Models\Token;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearExpiredTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Автоочищение истёкших токенов';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = Token::where('expires_at', '<', now())->delete();
        $this->info("Удалено просроченных токенов: {$deleted}");

        // Логирование для мониторинга
        Log::info("ClearExpiredTokens: удалено {$deleted} токенов");
    }
}
