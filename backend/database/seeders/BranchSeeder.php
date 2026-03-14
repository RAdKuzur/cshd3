<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            DB::table('branches')->truncate();
            $templatePath = storage_path('excel/Помещения.xlsx');
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
            $index = 1;
            $branches = [];
            while (true) {
                $branch = $sheet->getCell('C'. $index)->getValue();
                $index++;
                if ($branch != null) {
                    if (!in_array($branch, $branches)) {
                        $branches[] = $branch;
                    }
                    continue;
                }
                break;
            }
            foreach ($branches as $branch) {
                DB::table('branches')->insert([
                    'name' => $branch,
                    'organization_id' => DB::table('organizations')->where(['name' => 'Московский областной суд'])->first()->id,
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
