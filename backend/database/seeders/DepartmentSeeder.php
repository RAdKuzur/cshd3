<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //departments
        DB::table('departments')->truncate();
        $organizationId = DB::table('organizations')->first()->id;
        DB::table('departments')->insert([
            'name' => 'A',
            'organization_id' => $organizationId,
            'address' => 'Россия, Московская область',
        ]);
        DB::table('departments')->insert([
            'name' => 'B',
            'organization_id' => $organizationId,
            'address' => 'Россия, Московская область',
        ]);
        DB::table('departments')->insert([
            'name' => 'C',
            'organization_id' => $organizationId,
            'address' => 'Россия, Московская область',
        ]);
        DB::table('departments')->insert([
            'name' => 'D',
            'organization_id' => $organizationId,
            'address' => 'Россия, Московская область',
        ]);
    }
}
