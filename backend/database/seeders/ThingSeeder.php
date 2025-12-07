<?php

namespace Database\Seeders;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use DateTime;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ThingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public const EXCEL_PATH = __DIR__ . '/../../storage/excel/ОС.xlsx';
    public function run(): void
    {
        $index = 1;
        $thingIndex = 1;
        //if (file_exists(self::EXCEL_PATH)) {
            $spreadsheet = IOFactory::load(self::EXCEL_PATH);
            $sheet = $spreadsheet->getActiveSheet();
            DB::beginTransaction();
            try {
                while (trim($sheet->getCell('A' . $index)->getValue())) {
                    $number = preg_replace('/\s+/u', '', $sheet->getCell('A' . $index)->getValue());
                    if ($thingIndex == $number) {
                        $data = [
                            'name' => $sheet->getCell('C' . $index)->getValue() ?: 'б/н',
                            'serial_number' => 'б/н',
                            'inv_number' => $sheet->getCell('J' . $index)->getValue() ?: 'б/н',
                            'operation_date' => ($date = DateTime::createFromFormat('d.m.Y', $sheet->getCell('O' . $index)->getValue())) ? $date->getTimestamp() : null,
                            'thing_type_id' => rand(ThingTypeDictionary::PC, ThingTypeDictionary::OTHER),
                            'thing_parent_id' => null,
                            'condition' => ConditionDictionary::OK,
                            'auditorium_id' => DB::table('auditoriums')->inRandomOrder()->first()->id,
                            'price' => str_replace(',', '.', preg_replace('/\s+/u', '', $sheet->getCell('T' . $index)->getValue())),
                            'comment' => null,
                            'balance' => ThingBalanceDictionary::OS
                        ];

                        DB::table('things')->insert($data);
//                        echo $thingIndex . "\n";
                        $thingIndex++;
                    }
                    $index++;
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                echo "Ошибка импорта: " . $e->getMessage();
                throw $e;
            }
        //}
    }
}
