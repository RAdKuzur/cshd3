<?php

namespace App\Console\Commands;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Models\Thing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $templatePath = storage_path('excel.xlsx');
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
            for($i = 2; $i <= 1000; $i++) {
                $cabinet = $sheet->getCell('A' . $i)->getValue();
                $name = $sheet->getCell('B' . $i)->getValue();
                $secondName = $sheet->getCell('C' . $i)->getValue();
                $invNumber = $sheet->getCell('D' . $i)->getValue();
                $serialNumber = $sheet->getCell('E' . $i)->getValue();
                $type = trim($sheet->getCell('F' . $i)->getValue());
                $price = $sheet->getCell('H' . $i)->getValue();
                $comment = $sheet->getCell('I' . $i)->getValue();
                if ($cabinet != '') {
                    $raw = $sheet->getCell('G' . $i)->getValue();
                    if(trim($raw)== ""){
                        $raw = "01.01.2020";
                    }
                    if (is_numeric($raw)) {
                        $date = Date::excelToDateTimeObject($raw)->format('d.m.Y');
                    } else {
                        $date = $raw;
                    }

                    $date = \DateTime::createFromFormat('d.m.Y', $date)->format('Y-m-d') . "\n";
                    $thingID = DB::table('things')->insertGetId([
                        'name' => $name,
                        'second_name' => $secondName,
                        'serial_number' => $serialNumber,
                        'inv_number' => $invNumber,
                        'operation_date' => $date,
                        'thing_type_id' => ThingTypeDictionary::index($type),
                        'thing_parent_id' => null,
                        'condition' => ConditionDictionary::OK,
                        'balance' => ThingBalanceDictionary::NONE_BALANCE,
                        'price' => (float)$price,
                        'comment' => $comment,
                        'is_composite' => false,
                        'is_blocked' => Thing::NOT_BLOCKED,
                    ]);
//                    $auditoriumID = DB::table('auditoriums')->where(['name' => $cabinet])->first()->id . "\n";
                    $auditoriumID = DB::table('auditoriums')->inRandomOrder()->first()->id . "\n";
                    DB::table('thing_auditoriums')->insert([
                        'thing_id' => $thingID,
                        'auditorium_id' => $auditoriumID,
                        'start_date' => now(),
                        'end_date' => null,
                    ]);
                }
            }
            DB::commit();
        }
        catch (\Exception $exception) {
            echo $i . " : " . $exception->getMessage();
            DB::rollBack();
        }
    }
}
