<?php

namespace Database\Seeders;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Dictionaries\TransferActDictionary;
use App\Models\Thing;
use App\Services\ElasticsearchService;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ThingSeeder extends Seeder
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
        $this->elasticsearchService->create('things');
        //things-electronics
        DB::table('things')->truncate();
        for($i = 1; $i <= 1000; $i++){
            $thingId = DB::table('things')->insertGetId([
                'name' => fake()->word(),
                'serial_number' => $i,
                'inv_number' => $i,
                'operation_date' => Carbon::create(
                    rand(2010, 2025),
                    rand(1, 12),
                    rand(1, 28),
                    rand(0, 23),
                    rand(0, 59),
                    rand(0, 59)
                )->toDateTimeString(),
                'thing_type_id' => rand(ThingTypeDictionary::PC, ThingTypeDictionary::OTHER),
                'thing_parent_id' => null,
                'condition' => ConditionDictionary::OK,
                'price' => rand(1, 100000),
                'comment' => $fakeText = fake()->text(),
                'balance' => ThingBalanceDictionary::NONE_BALANCE,
                'is_composite' => false,
                'is_blocked' => Thing::NOT_BLOCKED
            ]);
            $this->elasticsearchService->index(
                'things',
                [
                    'comment' => $fakeText,
                    'id' => $thingId
                ]
            );

        }
        //things-furniture
        for($i = 1001; $i <= 2000; $i++){
            $thingId = DB::table('things')->insertGetId([
                'name' => fake()->word(),
                'serial_number' => $i,
                'inv_number' => $i,
                'operation_date' => Carbon::create(
                    rand(2010, 2025),
                    rand(1, 12),
                    rand(1, 28),
                    rand(0, 23),
                    rand(0, 59),
                    rand(0, 59)
                )->toDateTimeString(),
                'thing_type_id' => rand(ThingTypeDictionary::TABLE, ThingTypeDictionary::SOFA),
                'thing_parent_id' => null,
                'condition' => ConditionDictionary::OK,
                'price' => rand(1, 100000),
                'comment' => $fakeText = fake()->text(),
                'balance' => ThingBalanceDictionary::NONE_BALANCE,
                'is_composite' => false,
                'is_blocked' => Thing::NOT_BLOCKED
            ]);
            $this->elasticsearchService->index(
                'things',
               [
                   'comment' => $fakeText,
                   'id' => $thingId
               ]
            );
        }
        //thing_auditoriums
        DB::table('thing_auditoriums')->truncate();
        foreach (DB::table('things')->get() as $thing){
            DB::table('thing_auditoriums')->insert([
                'thing_id' => $thing->id,
                'auditorium_id' => DB::table('auditoriums')->inRandomOrder()->first()->id,
                'start_date' => now(),
                'end_date' => null,
            ]);
        }
    }
}
