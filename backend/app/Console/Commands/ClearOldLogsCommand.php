<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearOldLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-old-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Автоочищение старых логов';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (DB::table('logs')->exists()) {
            DB::table('logs')->where('time', '<', now()->minus(
                seconds: 60
            ))->delete();
        }
        if (DB::table('error_logs')->exists()) {
            DB::table('error_logs')->where('time', '<', now()->minus(
                seconds: 60
            ))->delete();
        }
    }
}
