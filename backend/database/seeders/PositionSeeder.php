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
        $positions = [
            'Директор',
            'Специалист',
            'Судья',
            'Программист',
            'IT-специалист',
            'Бухгалтер',
            'Спец. отдела кадров'
        ];
        DB::table('positions')->truncate();
        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'name' => $position
            ]);
        }
    }
}
