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
            'name' => 'Московский областной суд',
            'address' => 'Россия, Московская область',
            'inn' => 7718123097,
            'ogrn' => 1037718041261,
        ]);
        //departments
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
        $A = [
            'name' => [ 'A1002', 'A1003', 'A1005', 'A1001', 'A1006', 'A1007', 'A1010', 'A1051', 'A1052' ],
            'number' => [ 1002, 1003, 1005, 1001, 1006, 1007, 1010, 1051, 1052 ],
            'floor' => [ 1, 1, 1, 1, 1, 1, 1, 1 , 1]
        ];
        $B = [
            'name' => [ 'B1016', 'B1017', 'B1018', 'B1019', 'B1020', 'B1021', 'B1022', 'B1024', 'B1025', 'B1030' ],
            'number' => [ 1016, 1017, 1018, 1019, 1020, 1021, 1022, 1024, 1025, 1030],
            'floor' => [ 1, 1, 1, 1, 1, 1, 1, 1, 1, 1]
        ];
        $C = [
            'name' => [ 'C1031', 'C1034', 'C1035', 'C1036', 'C1038', 'C1042', 'C1043' ],
            'number' => [ 1031, 1034, 1035, 1036, 1038, 1042, 1043 ],
            'floor' => [ 1, 1, 1, 1, 1, 1, 1 ]
        ];
        $D = [
            'name' => [ 'D1044', 'D1045', 'D1048'],
            'number' => [ 1044, 1045, 1048 ],
            'floor' => [ 1, 1, 1 ]
        ];
        $aId = DB::table('departments')->where('name', 'A' )->first()->id;
        foreach ($A['number'] as $index => $number) {
            DB::table('auditoriums')->insert([
                'name' => $A['name'][$index],
                'number' => $A['number'][$index],
                'floor' => $A['floor'][$index],
                'department_id' => $aId
            ]);
        }
        $bId = DB::table('departments')->where('name', 'B' )->first()->id;
        foreach ($B['number'] as $index => $number) {
            DB::table('auditoriums')->insert([
                'name' => $B['name'][$index],
                'number' => $B['number'][$index],
                'floor' => $B['floor'][$index],
                'department_id' => $bId
            ]);
        }
        $cId = DB::table('departments')->where('name', 'C' )->first()->id;
        foreach ($C['number'] as $index => $number) {
            DB::table('auditoriums')->insert([
                'name' => $C['name'][$index],
                'number' => $C['number'][$index],
                'floor' => $C['floor'][$index],
                'department_id' => $cId
            ]);
        }
        $dId = DB::table('departments')->where('name', 'D' )->first()->id;
        foreach ($D['number'] as $index => $number) {
            DB::table('auditoriums')->insert([
                'name' => $D['name'][$index],
                'number' => $D['number'][$index],
                'floor' => $D['floor'][$index],
                'department_id' => $dId
            ]);
        }
    }
}
