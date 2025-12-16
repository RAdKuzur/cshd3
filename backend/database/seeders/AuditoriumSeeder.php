<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var $department Department */
        DB::table('auditoriums')->truncate();
        for($i = 1; $i <= 1000; $i++) {
            $department = DB::table('departments')->inRandomOrder()->first();
            $floor = random_int(1, 8);
            DB::table('auditoriums')->insert([
                'name' => $department->name . $floor . $i,
                'number' =>  $floor . $i,
                'floor' => $floor,
                'department_id' => $department->id,
                'branch_id' => DB::table('branches')->inRandomOrder()->first()->id,
                'comment' => 'Какой-то комментарий №' . $i,
            ]);
        }

    }
}
