<?php

namespace App\Console\Commands;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TransferExcelToDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:excel-to-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Трансформирует данные из файла xls/xlsx в БД';

    /**
     * Execute the console command.
     */
    public const EXCEL_PATH = "C:/Users/rkuzu/OneDrive/Desktop/МОСОБЛСУД/Таблица 1 этаж.xlsx";

    public function handle()
    {
        if (file_exists(self::EXCEL_PATH)) {
            $index = 1;
            $spreadsheet = IOFactory::load(self::EXCEL_PATH);
            $sheet = $spreadsheet->getActiveSheet();
            DB::beginTransaction();

            try {
                while ($cellValue = trim($sheet->getCell('A' . $index)->getValue())) {
                    // Получаем значение аудитории один раз
                    $auditoriumName = trim($sheet->getCell('F' . $index)->getValue());
                    $auditorium = DB::table('auditoriums')->where(['name' => $auditoriumName])->first();
                    if (!$auditorium) {
                        throw new Exception("Аудитория '{$auditoriumName}' не найдена в строке {$index}");
                    }
                    $data = [
                        'name' => $sheet->getCell('B' . $index)->getValue() ?: 'б/н',
                        'serial_number' => $sheet->getCell('C' . $index)->getValue() ?: 'б/н',
                        'inv_number' => $sheet->getCell('D' . $index)->getValue() ?: 'б/н',
                        'operation_date' => $sheet->getCell('E' . $index)->getValue() ? $sheet->getCell('E' . $index)->getValue() . '-01-01 00:00:00' : null,
                        'thing_type_id' => ThingTypeDictionary::indexElectronics($cellValue),
                        'thing_parent_id' => null,
                        'condition' => rand(ConditionDictionary::OK, ConditionDictionary::BROKEN),
                        'auditorium_id' => $auditorium->id,
                        'price' => 1,
                        'comment' => null,
                        'balance' => rand(ThingBalanceDictionary::OS, ThingBalanceDictionary::BALANCE)
                    ];

                    DB::table('things')->insert($data);
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
