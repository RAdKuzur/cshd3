<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            'name' => 'Moscow Court',
            'address' => 'Russia, Moscow',
            'inn' => 111111,
            'ogrn' => '111111',
        ]);
    }
}
