<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //organizations
        DB::table('organizations')->truncate();
        DB::table('organizations')->insert([
            'name' => 'Московский областной суд',
            'address' => 'Россия, Московская область',
            'inn' => 7718123097,
            'ogrn' => 1037718041261,
        ]);
    }
}
