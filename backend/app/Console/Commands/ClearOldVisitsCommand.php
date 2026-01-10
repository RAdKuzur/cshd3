<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearOldVisitsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-old-visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Автоочищение старых посещений';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (DB::table('visits')->exists()) {
            DB::table('visits')->where('request_time', '<', now()->minus(
                seconds: 60
            ))->delete();
        }
    }
}
