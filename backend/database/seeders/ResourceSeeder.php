<?php

namespace Database\Seeders;

use App\Dictionaries\ResourceTypeDictionary;
use App\Dictionaries\ThingTypeDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //companies
        DB::table('companies')->truncate();
        for($i = 0; $i < 10; $i++){
            DB::table('companies')->insert([
                'name' => fake()->company()
            ]);
        }

        //models
        DB::table('models')->truncate();
        foreach(DB::table('companies')->get() as $company){
            for($i = 0; $i < 4; $i++) {
                DB::table('models')->insert([
                    'name' => fake()->word(),
                    'company_id' => $company->id
                ]);
            }
        }

        //device
        DB::table('devices')->truncate();
        $things = DB::table('things')->whereIn('thing_type_id', [
            ThingTypeDictionary::CARD_PRINTER,
            ThingTypeDictionary::PRINTER_BW,
            ThingTypeDictionary::PRINTER_COLOUR,
            ThingTypeDictionary::MFU_A3_BW,
            ThingTypeDictionary::MFU_A3_COLOUR,
            ThingTypeDictionary::MFU_A4_BW,
            ThingTypeDictionary::MFU_A4_COLOUR
        ])->get();
        foreach($things as $thing){
            DB::table('devices')->insert([
                'thing_id' => $thing->id,
                'model_id' => DB::table('models')->inRandomOrder()->first()->id,
            ]);
        }

        //resources
        DB::table('resources')->truncate();
        for($i = 0; $i < 400; $i++) {
            DB::table('resources')->insert([
                'name' => fake()->word(),
                'type' => rand(ResourceTypeDictionary::CARTRIDGE, ResourceTypeDictionary::PAPER),
                'amount' => rand(1, 100)
            ]);
        }

        //model_resources
        DB::table('model_resources')->truncate();
        foreach (DB::table('models')->get() as $model){
            DB::table('model_resources')->insert([
                'model_id' => $model->id,
                'resource_id' => DB::table('resources')->inRandomOrder()->first()->id,
            ]);
        }
    }
}
