<?php

namespace Database\Seeders;

use App\Models\People;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeoplePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = DB::table('branches')->first();
        foreach (People::all() as $person) {
            foreach (Position::all() as $position) {
                DB::table('people_positions')->insert([
                    'people_id' => $person->id,
                    'position_id' => $position->id,
                    'is_active' => true,
                    'branch_id' => $branch->id,
                ]);
            }
        }
    }
}
