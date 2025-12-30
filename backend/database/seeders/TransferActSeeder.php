<?php

namespace Database\Seeders;

use App\Dictionaries\TransferActDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferActSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //transfer_acts
        DB::table('transfer_acts')->truncate();
        for ($i = 0; $i < 10; $i++) {
            DB::table('transfer_acts')->insertGetId([
                'from' => null,
                'to' => DB::table('people')->inRandomOrder()->first()->id,
                'date' => date('Y-m-d'),
                'confirmed' => 1,
                'type' => TransferActDictionary::TRANSFER,
            ]);
        }
        //transfer_act_things
        DB::table('transfer_act_things')->truncate();
        foreach (DB::table('things')->get() as $things) {
            DB::table('transfer_act_things')->insert([
                'thing_id' => $things->id,
                'transfer_act_id' => DB::table('transfer_acts')->inRandomOrder()->first()->id,
            ]);
        }
    }
}
