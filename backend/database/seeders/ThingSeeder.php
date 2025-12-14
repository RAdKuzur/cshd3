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
    public const EXCEL_PATH = __DIR__ . '/../../storage/excel/АРМ.xlsx';
    public function run(): void
    {
        if (file_exists(self::EXCEL_PATH)) {
            $spreadsheet = IOFactory::load(self::EXCEL_PATH);
            $sheet = $spreadsheet->getActiveSheet();
            DB::beginTransaction();
            try {
                for($i = 3; $i <= 2000; $i++) {
                    if($sheet->getCell("C" . $i)->getValue()){
                        $data = [
                            'name' => $sheet->getCell('C' . $i)->getValue() ?: 'НЕИЗВЕСТНОЕ НАЗВАНИЕ',
                            'serial_number' => $sheet->getCell('F' . $i)->getValue() ?: 'б/н',
                            'inv_number' => $sheet->getCell('E' . $i)->getValue() ?: 'б/н',
                            'operation_date' => (new DateTime('1899-12-31'))->modify('+' . ($sheet->getCell('H' . $i)->getValue() - ($sheet->getCell('H' . $i)->getValue() > 60 ? 1 : 0)) . ' days')->getTimestamp() > 0
                                ? (new DateTime('1899-12-31'))->modify('+' . ($sheet->getCell('H' . $i)->getValue() - ($sheet->getCell('H' . $i)->getValue() > 60 ? 1 : 0)) . ' days')->format('Y-m-d') : null ,
                            'thing_type_id' => ThingTypeDictionary::ARM,
                            'thing_parent_id' => null,
                            'condition' => ConditionDictionary::OK,
//                            'auditorium_id' => DB::table('auditoriums')->where([
//                                'name' =>  $sheet->getCell('J' . $i)->getValue() .  $sheet->getCell('K' . $i)->getValue()
//                            ])->first()->id,
                            'price' => (str_replace(',', '.', preg_replace('/\s+/u', '', $sheet->getCell('I' . $i)->getValue()))
                                ? str_replace(',', '.', preg_replace('/\s+/u', '', $sheet->getCell('I' . $i)->getValue()))
                                : 1),
                            'comment' => null,
                            'balance' => ThingBalanceDictionary::index($sheet->getCell('G' . $i)->getValue())
                        ];
                        $thingId = DB::table('things')->insertGetId($data);
                        $auditoriumId = DB::table('auditoriums')->where([
                                'name' =>  $sheet->getCell('J' . $i)->getValue() .  $sheet->getCell('K' . $i)->getValue()
                            ])->first()->id;
                        DB::table('thing_auditoriums')->insertGetId([
                            'thing_id' => $thingId,
                            'auditorium_id' => $auditoriumId,
                            'start_date' => now(),
                            'end_date' => null,
                        ]);
                    }
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                echo "Ошибка импорта: " . $e->getMessage();
                throw $e;
            }
        }
        else {
            echo 'file not found ' . self::EXCEL_PATH;
        }
    }
}
