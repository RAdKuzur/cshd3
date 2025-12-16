<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->truncate();
        for($i = 1; $i <= 10; $i++) {
            DB::table('branches')->insert([
                'name' => 'Отдел №' . $i,
                'organization_id' => DB::table('organizations')->first()->id,
            ]);
        }
    }
}
