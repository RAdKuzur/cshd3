<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Инициализация начальных данных из excel-таблицы';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
