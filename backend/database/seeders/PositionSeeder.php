<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //position
        DB::table('positions')->truncate();
        for($i = 1; $i <= 10; $i++) {
            DB::table('positions')->insert([
                'name' => 'Должность №' . $i
            ]);
        }
    }
}
