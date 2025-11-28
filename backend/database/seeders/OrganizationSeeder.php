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
        //organizations
        DB::table('organizations')->insert([
            'name' => 'Moscow Court',
            'address' => 'Russia, Moscow',
            'inn' => 111111,
            'ogrn' => '111111',
        ]);
        //departments
        foreach(DB::table('organizations')->get() as $organization) {
            for($i = 1; $i <= 4; $i++) {
                DB::table('departments')->insert([
                    'name' => 'Корпус №'. $i,
                    'organization_id' => $organization->id,
                    'address' => 'Moscow',
                ]);
            }
        }
        //branches
        foreach(DB::table('organizations')->get() as $organization) {
            for($i = 1; $i <= 4; $i++) {
                DB::table('branches')->insert([
                    'name' => 'Отдел #' . $i,
                    'organization_id' => $organization->id,
                ]);
            }
        }
        //auditoriums
        foreach(DB::table('departments')->get() as $department) {
            for($i = 1; $i <= 10; $i++) { //floor
                for ($k = 1; $k <= 30; $k++) { //auditoriums
                    DB::table('auditoriums')->insert([
                        'name' => 'Кабинет №' . $i. $k,
                        'number' => $i. $k,
                        'floor' => $i,
                        'department_id' => $department->id
                    ]);
                }
            }
        }
    }
}
