<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class OrganizationSeeder extends Seeder
{
    public const AUDITORIUM_EXCEL_PATH = __DIR__ . '/../../storage/excel/Помещения.xlsx';
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

        if (file_exists(self::AUDITORIUM_EXCEL_PATH)) {
            $index = 1;
            $spreadsheet = IOFactory::load(self::AUDITORIUM_EXCEL_PATH);
            $sheet = $spreadsheet->getActiveSheet();
            DB::beginTransaction();
            try {
                while ($cellValue = trim($sheet->getCell('A' . $index)->getValue())) {
                    $branch = $sheet->getCell('C' . $index)->getValue();
                    if (!DB::table("branches")->where("name", $branch)->exists()) {
                        DB::table("branches")->insert([
                            "name" => $branch,
                            'organization_id' => DB::table('organizations')->first()->id,
                        ]);
                    }
                    $index++;
                }
                $index = 1;
                while ($cellValue = trim($sheet->getCell('A' . $index)->getValue())) {
                    $branch = $sheet->getCell('C' . $index)->getValue();
                    DB::table('auditoriums')->insert([
                        'name' => $sheet->getCell('A' . $index)->getValue() . $sheet->getCell('B' . $index)->getValue(),
                        'number' => $sheet->getCell('B' . $index)->getValue(),
                        'floor' => ((string)($sheet->getCell('B' . $index)->getValue()))[0],
                        'department_id' => DB::table('departments')->where('name', $cellValue)->value('id'),
                        'branch_id' => DB::table('branches')->where('name', $branch)->value('id'),
                        'comment' => 'Текст назначения кабинета'
                    ]);
                    $index++;
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                echo "Ошибка импорта: " . $e->getMessage();
                throw $e;
            }
        }
        else {
            echo "Файл не найден". "\n";
        }
    }
}
