<?php

namespace Database\Seeders;

use App\Dictionaries\ThingTypeDictionary;
use App\Services\ElasticsearchService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NetworkThingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private ElasticsearchService $elasticsearchService;
    public function __construct(
        ElasticsearchService $elasticsearchService
    )
    {
        $this->elasticsearchService = $elasticsearchService;
    }
    public function run(): void
    {
        $this->elasticsearchService->create('network-things');

        DB::table('network_things')->truncate();
        $networkThings = DB::table('things')->whereIn('thing_type_id', [
            ThingTypeDictionary::PC, ThingTypeDictionary::ARM, ThingTypeDictionary::FAX, ThingTypeDictionary::KMA,
            ThingTypeDictionary::PRINTER_BW, ThingTypeDictionary::SERVER, ThingTypeDictionary::NETWORK_BORDER, ThingTypeDictionary::MONOPC,
            ThingTypeDictionary::STORAGE
        ])->get();
        foreach ($networkThings as $networkThing) {
            $networkThingsId = DB::table('network_things')->insertGetId([
                'thing_id' => $networkThing->id,
                'ip_address' => fake()->ipv4(),
                'phone_number' => null,
                'comment' => $fakeText = fake()->text()
            ]);
            $this->elasticsearchService->index(
                'network-things',
                [
                    'comment' => $fakeText,
                    'id' => $networkThingsId
                ]
            );
        }

        $telephones = DB::table('things')->whereIn('thing_type_id', [
            ThingTypeDictionary::IP_TELEPHONE
        ])->get();
        foreach ($telephones as $telephone) {
            $networkThingsId = DB::table('network_things')->insertGetId([
                'thing_id' => $telephone->id,
                'ip_address' => null,
                'phone_number' => fake()->phoneNumber(),
                'comment' => $fakeText = fake()->text()
            ]);
            $this->elasticsearchService->index(
                'network-things',
                [
                    'comment' => $fakeText,
                    'id' => $networkThingsId
                ]
            );
        }
    }
}
