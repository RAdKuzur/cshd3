<?php

namespace App\Console\Commands;

use App\Dictionaries\LicenceDictionary;
use App\Services\LicenceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LicenceCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:licence-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка лицензий';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = env('LICENCE_URL_APP');
        $key = env('APP_KEY');
        if ($url) {
            $response = Http::post($url, [
                'key' => $key
            ]);
            if ($response->status() == 200) {
                DB::table('licences')->truncate();
                DB::table('licences')->insert([
                    'code' => $response->json()['code'],
                    'expires_at' => $response->json()['expires_at'],
                    'is_revoked' => $response->json()['is_revoked'],
                ]);
            }
        }
    }
}
