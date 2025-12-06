<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TransferAuditoriumDataFromExcelToDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-auditorium-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт кабинетов и отделов в БД';
    public const AUDITORIUM_EXCEL_PATH = "C:/Users/rkuzu/OneDrive/Desktop/МОСОБЛСУД/Помещения.xlsx";
    /**
     * Execute the console command.
     */
    public function handle()
    {
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
                    DB::table('auditoriums')->insert([
                        'name' => $sheet->getCell('A' . $index)->getValue() . $sheet->getCell('B' . $index)->getValue(),
                        'number' => $sheet->getCell('B' . $index)->getValue(),
                        'floor' => ((string)($sheet->getCell('B' . $index)->getValue()))[0],
                        'department_id' => DB::table('departments')->where('name', $cellValue)->value('id'),
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
