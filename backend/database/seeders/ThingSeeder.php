<?php

namespace Database\Seeders;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Dictionaries\TransferActDictionary;
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
    public function run(): void
    {
        //things
        DB::table('things')->truncate();
        for($i = 1; $i <= 5000; $i++){
            DB::table('things')->insert([
                'name' => 'THING #' . $i,
                'serial_number' => $i,
                'inv_number' => $i,
                'operation_date' => Carbon::create(
                    rand(2000, 2025),
                    rand(1, 12),
                    rand(1, 28),
                    rand(0, 23),
                    rand(0, 59),
                    rand(0, 59)
                )->toDateTimeString(),
                'thing_type_id' => array_rand(array_keys(ThingTypeDictionary::type())),
                'thing_parent_id' => null,
                'condition' => ConditionDictionary::OK,
                'price' => rand(1, 100000),
                'comment' => null,
                'balance' => array_rand(array_keys(ThingBalanceDictionary::type())),
                'is_composite' => false
            ]);
        }
        //thing_responsibilities
        DB::table('thing_responsibilities')->truncate();
        foreach (DB::table('things')->get() as $thing){
            DB::table('thing_responsibilities')->insert([
                'thing_id' => $thing->id,
                'people_id' => DB::table('people')->inRandomOrder()->first()->id,
                'start_date' => now(),
                'end_date' => null,
            ]);
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
