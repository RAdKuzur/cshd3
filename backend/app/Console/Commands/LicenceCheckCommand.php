<?php

namespace App\Console\Commands;

use App\Dictionaries\LicenceDictionary;
use App\Services\LicenceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use function Psy\debug;

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
        $url = env('LICENCE_URL_APP'); # путь к лицензии
        $licenceKeys = DB::table('licences')->get();
        $key = env('APP_KEY'); # ключ приложения Laravel
        DB::beginTransaction();
        try {
            foreach ($licenceKeys as $licenceKey) {
                if ($licenceKey && $url) {
                    try {
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
                                DB::table('licences')->where(['id' => $licenceKey->id])->delete();
                                break;
                            default:
                                DB::table('licences')->where(['id' => $licenceKey->id])->update(
                                    [
                                        'is_revoked' => LicenceDictionary::REVOKED,
                                    ]
                                );
                                break;
                        }
                    }
                    catch (\Exception $e) {
                        // если эндпойнт не отвечает
                        // DB::table('licences')->where(['id' => $licenceKey->id])->update(
                        //     [
                        //         'is_revoked' => LicenceDictionary::REVOKED,
                        //     ]
                        // );
                        DB::rollBack();
                    }
                }
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
