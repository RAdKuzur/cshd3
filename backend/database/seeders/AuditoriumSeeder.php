<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('auditoriums')->truncate();
//        for($i = 1; $i <= 1000; $i++) {
//            $department = DB::table('departments')->inRandomOrder()->first();
//            $floor = random_int(1, 8);
//            DB::table('auditoriums')->insert([
//                'name' => $department->name . $floor . $i,
//                'number' =>  $floor . $i,
//                'floor' => $floor,
//                'department_id' => $department->id,
//                'branch_id' => DB::table('branches')->inRandomOrder()->first()->id,
//                'area' => random_int(30, 70),
//                'comment' => fake()->text(),
//            ]);
//        }
        DB::beginTransaction();
        try {
            DB::table('auditoriums')->truncate();
            $templatePath = storage_path('excel/Помещения.xlsx');
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
            $index = 1;
            while (true) {
                $department = $sheet->getCell('A'. $index)->getValue();
                $number = $sheet->getCell('B'. $index)->getValue();
                $branch = $sheet->getCell('C'. $index)->getValue();
                $comment = $sheet->getCell('D'. $index)->getValue();
                $index++;
                if ($branch != null) {
                    $auditorium = [
                        'name' =>  $department . $number,
                        'number' =>  $number,
                        'floor' => ((string)$number)[0],
                        'department_id' => DB::table('departments')->where('name', $department)->first()->id,
                        'branch_id' => DB::table('branches')->where('name', $branch)->first()->id,
                        'area' => 0,
                        'comment' => $comment
                    ];
                    DB::table('auditoriums')->insert($auditorium);
                }
                else {
                    break;
                }
            }
            DB::commit();
        }
        catch (\Exception $e) {
            echo $e->getTraceAsString();
            DB::rollBack();
        }
    }
}
