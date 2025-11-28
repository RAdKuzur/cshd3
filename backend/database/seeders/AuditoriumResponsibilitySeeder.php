<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditoriumResponsibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //auditorium_responsibilities
        foreach (DB::table('auditorium_responsibilities')->get() as $auditorium) {
            DB::table('auditorium_responsibilities')->insert([
                'auditorium_id' => $auditorium->id,
                'people_id' =>  DB::table('people')->inRandomOrder()->first()->id,
                'start_date' => now(),
                'is_active' => true
            ]);
        }
    }
}
