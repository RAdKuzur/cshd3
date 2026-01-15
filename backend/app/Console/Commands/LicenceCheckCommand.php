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
        DB::beginTransaction();
        try {
            $url = env('LICENCE_URL_APP');
            $licenceKey = DB::table('licences')->where([
                ['is_revoked', '=', LicenceDictionary::ACTIVE],
                ['expires_at', '>', now()]
            ])->first();
            $key = env('APP_KEY');
            if ($licenceKey && $url) {
                $response = Http::post($url, [
                    'app_key' => $key,
                    'licence_key' => $licenceKey->code,
                ]);
                switch ($response->status()) {
                    case 200:
                    case 403:
                        DB::table('licences')->where(['id' => $licenceKey->id])->update(
                            [
                                'is_revoked' => $response->json()['data']['is_revoked'],
                                'expires_at' => $response->json()['data']['expires_at']
                            ]
                        );
                        break;
                    case 404:
                        DB::table('licences')->where(['id' => $licenceKey->id])->update(
                            [
                                'is_revoked' => LicenceDictionary::REVOKED,
                            ]
                        );
                        break;
                }
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
