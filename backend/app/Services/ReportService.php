<?php

namespace App\Services;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ResourceTypeDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\DTO\Thing\ThingBranchDTO;
use App\DTO\Thing\ThingDTO;
use App\Helpers\Auth;
use App\Models\Auditorium;
use App\Repositories\AuditoriumRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\ModelRepository;
use App\Repositories\NetworkThingRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\ThingRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;

class ReportService
{
    public AuditoriumRepository $auditoriumRepository;
    public OrganizationRepository $organizationRepository;
    public ThingRepository $thingRepository;
    public ModelRepository $modelRepository;
    public DeviceRepository $deviceRepository;
    public NetworkThingRepository $networkThingRepository;
    public function __construct(
        AuditoriumRepository $auditoriumRepository,
        OrganizationRepository $organizationRepository,
        ThingRepository $thingRepository,
        ModelRepository $modelRepository,
        DeviceRepository $deviceRepository,
        NetworkThingRepository $networkThingRepository
    )
    {
        $this->auditoriumRepository = $auditoriumRepository;
        $this->organizationRepository = $organizationRepository;
        $this->thingRepository = $thingRepository;
        $this->modelRepository = $modelRepository;
        $this->deviceRepository = $deviceRepository;
        $this->networkThingRepository = $networkThingRepository;
    }

    public function auditoriumReport($id)
    {
        $auditorium = $this->auditoriumRepository->getWithThingsById($id);
        $phpWord = new PhpWord();
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'allCaps' => true], ['align' => Jc::CENTER]);
        $phpWord->addParagraphStyle(Jc::CENTER, ['align' => Jc::CENTER]);
        $phpWord->addParagraphStyle('centerItalic', ['align' => Jc::CENTER]);
        $phpWord->addFontStyle('italic14', ['italic' => true, 'size' => 12]);
        $section = $phpWord->addSection();
        $section->addText($auditorium->branch->organization->name , ['size' => 14], ['align' => Jc::CENTER]);
        $section->addText($auditorium->branch->organization->address, ['italic' => true, 'size' => 12], ['align' => Jc::CENTER]);
        $section->addText('ПАСПОРТ КАБИНЕТА', ['bold' => true, 'size' => 14, 'allCaps' => true], ['align' => Jc::CENTER]);
        $section->addText('Кабинет № ' . $auditorium->name,  ['italic' => true, 'size' => 12], ['align' => Jc::CENTER]);
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 120,
            'alignment' => Jc::CENTER,
            'width' => 100 * 50,
            'unit' => TblWidth::PERCENT
        ]);
        $wNum      = 8 * 50;   // 8%
        $wName     = 60 * 50;  // 60%
        $wCount    = 10 * 50;  // 10%
        $wInv      = 22 * 50;  // 22%
        if(count($auditorium->getActualThings()) > 0){
            $table->addRow();
            $table->addCell($wNum)->addText('№', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addCell($wName)->addText('Наименование', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addCell($wCount)->addText('Кол-во', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addCell($wInv)->addText('Инвентарный номер', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addRow();
            $table->addCell(null, ['gridSpan' => 4, 'valign' => Jc::CENTER])->addText('ОФИСНАЯ МЕБЕЛЬ',
                ['bold' => true, 'size' => 14, 'allCaps' => true],
                ['alignment' => Jc::CENTER]
            );
            $thingAuditoriums = $auditorium->getActualThings();
            //Мебель
            foreach ($thingAuditoriums as $index => $item) {
                if (in_array($item->thing->thing_type_id, ThingTypeDictionary::FURNITURE)) {
                    $table->addRow();
                    $table->addCell($wNum)->addText($index + 1, ['size' => 12], ['alignment' => Jc::CENTER]);
                    $table->addCell($wName)->addText($item->thing->name, ['size' => 12]);
                    $table->addCell($wCount)->addText(
                        1,
                        ['size' => 14],
                        ['alignment' => Jc::CENTER]
                    );
                    $table->addCell($wInv)->addText($item->thing->inv_number, ['size' => 12], ['alignment' => Jc::CENTER]);
                }
            }
            $table->addRow();
            $table->addCell(null, ['gridSpan' => 4, 'valign' => Jc::CENTER])->addText('ОФИСНАЯ ТЕХНИКА',
                ['bold' => true, 'size' => 14, 'allCaps' => true],
                ['alignment' => Jc::CENTER]
            );
            //Техника
            foreach ($thingAuditoriums as $index => $item) {
                if (in_array($item->thing->thing_type_id, ThingTypeDictionary::ELECTRONICS)) {
                    $table->addRow();
                    $table->addCell($wNum)->addText($index + 1, ['size' => 12], ['alignment' => Jc::CENTER]);
                    $table->addCell($wName)->addText($item->thing->name, ['size' => 12]);
                    $table->addCell($wCount)->addText(
                        1,
                        ['size' => 14],
                        ['alignment' => Jc::CENTER]
                    );
                    $table->addCell($wInv)->addText($item->thing->inv_number, ['size' => 12], ['alignment' => Jc::CENTER]);
                }
            }
        }
        else {
            $section->addText('В ПОМЕЩЕНИИ НЕТ МАТ. ЦЕННОСТЕЙ' , ['size' => 14], ['align' => Jc::CENTER]);
        }
        $section->addTextBreak();
        $section->addText('Год проведения работ по текущему ремонту:', ['size' => 12], ['align' => Jc::LEFT]);
        $section->addText('Площадь помещения: ' .  $auditorium->area . ' кв.м.', ['size' => 12], ['align' => Jc::LEFT]);
        $section->addTextBreak();
        $section->addText('Ответственный за кабинет __________/____________________/', ['size' => 12], ['align' => Jc::LEFT]);
        $fileName = 'auditorium_report.docx';
        return response()->streamDownload(function () use ($phpWord) {
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
    public function allAuditoriumReport()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
        $auditoriums = $this->auditoriumRepository->getAll();
        if (empty($auditoriums)) {
            return response()->json(['message' => 'Нет данных для отчета'], 404);
        }
        $organization = $this->organizationRepository->getMainOrganization();
        $phpWord = new PhpWord();
        $phpWord->getSettings()->setUpdateFields(true);
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'allCaps' => true], ['align' => Jc::CENTER]);
        $phpWord->addParagraphStyle(Jc::CENTER, ['align' => Jc::CENTER]);
        $phpWord->addFontStyle('italic14', ['italic' => true, 'size' => 12]);
        $section = $phpWord->addSection();
        $section->addText($organization->name, ['size' => 14], ['align' => Jc::CENTER]);
        $section->addText($organization->address, ['italic' => true, 'size' => 12], ['align' => Jc::CENTER]);
        $section->addText('ОБЩИЙ ПАСПОРТ КАБИНЕТОВ',
            ['bold' => true, 'size' => 14, 'allCaps' => true],
            ['align' => Jc::CENTER]
        );
        $section->addTextBreak();
        foreach ($auditoriums as $auditorium) {
            $section->addTextBreak();
            $section->addText('Кабинет № ' . $auditorium->name,
                ['italic' => true, 'size' => 12],
                ['align' => Jc::CENTER]
            );
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 120,
                'alignment' => Jc::CENTER,
                'width' => 100 * 50,
                'unit' => TblWidth::PERCENT
            ]);
            $wNum      = 8 * 50;
            $wName     = 60 * 50;
            $wCount    = 10 * 50;
            $wInv      = 22 * 50;
            if (count($auditorium->getActualThings()) > 0) {
                $table->addRow();
                $table->addCell($wNum)->addText('№',
                    ['bold' => true, 'size' => 12],
                    ['alignment' => Jc::CENTER]
                );
                $table->addCell($wName)->addText('Наименование',
                    ['bold' => true, 'size' => 12],
                    ['alignment' => Jc::CENTER]
                );
                $table->addCell($wCount)->addText('Кол-во',
                    ['bold' => true, 'size' => 12],
                    ['alignment' => Jc::CENTER]
                );
                $table->addCell($wInv)->addText('Инвентарный номер',
                    ['bold' => true, 'size' => 12],
                    ['alignment' => Jc::CENTER]
                );
                $table->addRow();
                $table->addCell(null, ['gridSpan' => 4, 'valign' => Jc::CENTER])->addText('ОФИСНАЯ МЕБЕЛЬ',
                    ['bold' => true, 'size' => 14, 'allCaps' => true],
                    ['alignment' => Jc::CENTER]
                );
                $thingsAuditoriums = $auditorium->getActualThings();
                foreach ($thingsAuditoriums as $index => $item) {
                    if (in_array($item->thing->thing_type_id, ThingTypeDictionary::FURNITURE)){
                        $table->addRow();
                        $table->addCell($wNum)->addText($index + 1,
                            ['size' => 12],
                            ['alignment' => Jc::CENTER]
                        );
                        $table->addCell($wName)->addText($item->thing->name, ['size' => 12]);
                        $table->addCell($wCount)->addText(
                            $item->count ?? 1,
                            ['size' => 12],
                            ['alignment' => Jc::CENTER]
                        );
                        $table->addCell($wInv)->addText(
                            $item->thing->inv_number ?? '-',
                            ['size' => 12],
                            ['alignment' => Jc::CENTER]
                        );
                    }
                }
                $table->addRow();
                $table->addCell(null, ['gridSpan' => 4, 'valign' => Jc::CENTER])->addText('ОФИСНАЯ ТЕХНИКА',
                    ['bold' => true, 'size' => 14, 'allCaps' => true],
                    ['alignment' => Jc::CENTER]
                );
                foreach ($thingsAuditoriums as $index => $item) {
                    if (in_array($item->thing->thing_type_id, ThingTypeDictionary::ELECTRONICS)){
                        $table->addRow();
                        $table->addCell($wNum)->addText($index + 1,
                            ['size' => 12],
                            ['alignment' => Jc::CENTER]
                        );
                        $table->addCell($wName)->addText($item->thing->name, ['size' => 12]);
                        $table->addCell($wCount)->addText(
                            $item->count ?? 1,
                            ['size' => 12],
                            ['alignment' => Jc::CENTER]
                        );
                        $table->addCell($wInv)->addText(
                            $item->thing->inv_number ?? '-',
                            ['size' => 12],
                            ['alignment' => Jc::CENTER]
                        );
                    }
                }
            } else {
                $section->addText('В кабинете нет объектов материальных ценностей',
                    ['size' => 12, 'italic' => true],
                    ['align' => Jc::CENTER]
                );
            }
            unset($table);
            $section->addTextBreak();
            $section->addText('Год проведения работ по текущему ремонту:', ['size' => 12], ['align' => Jc::LEFT]);
            $section->addText('Площадь помещения: ' .  $auditorium->area . ' кв.м.', ['size' => 12], ['align' => Jc::LEFT]);
            $section->addTextBreak();
            $section->addText('Ответственный за кабинет __________/____________________/', ['size' => 12], ['align' => Jc::LEFT]);
            $section->addPageBreak(); // переход на новую страницу
        }
        $fileName = 'general_auditorium_report.docx';
        return response()->streamDownload(function () use ($phpWord) {
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
    public function thingReport()
    {
        $organization = $this->organizationRepository->getMainOrganization();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('ОБЪЕКТЫ МАТ.УЧЁТА');
        $sheet->setCellValue('A1', '№');
        $sheet->setCellValue('B1', 'Наименование');
        $sheet->setCellValue('C1', 'Инвентарный номер');
        $sheet->setCellValue('D1', 'Тип');
        $sheet->setCellValue('E1', 'Характеристика учёта');
        $sheet->setCellValue('F1', 'Дата введения в эксплуатацию');
        $sheet->setCellValue('G1', 'Балансовая стоимость');
        $sheet->setCellValue('H1', 'Помещение');
        $sheet->setCellValue('I1', 'Отдел');
        $sheet->setCellValue('J1', 'МОЛ');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $index = 2;
        foreach ($organization->departments as $department) {
            foreach ($department->auditoriums as $auditorium) {
                foreach ($auditorium->getActualThings() as $thingAuditorium) {
                    $sheet->setCellValue('A' . $index, $index - 1);
                    $sheet->setCellValue('B' . $index, $thingAuditorium->thing->name);
                    $sheet->setCellValue('C' . $index, $thingAuditorium->thing->inv_number);
                    $sheet->setCellValue('D' . $index, ThingTypeDictionary::get($thingAuditorium->thing->thing_type_id));
                    $sheet->setCellValue('E' . $index, ThingBalanceDictionary::get($thingAuditorium->thing->balance));
                    $sheet->setCellValue('F' . $index, $thingAuditorium->thing->operation_date);
                    $sheet->setCellValue('G' . $index, $thingAuditorium->thing->price);
                    $sheet->setCellValue('H' . $index, $auditorium->name);
                    $sheet->setCellValue('I' . $index, $thingAuditorium->auditorium->branch->name);
                    $sheet->setCellValue('J' . $index, $thingAuditorium->thing->getActualMaster()?->getFullFio());
                    $index++;
                }
            }
        }

        $fileName = 'thing_report.xlsx';
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function generalReport()
    {
        return $this->thingRepository
            ->getAllWithRelations()
            ->map(fn ($thing) => new ThingBranchDTO(
                id: $thing->id,
                name: $thing->name,
                serial_number: $thing->serial_number,
                inv_number: $thing->inv_number,
                operation_date: $thing->operation_date,
                thing_type_id: $thing->thing_type_id ? $thing->thing_type_id : null,
                thing_parent_id: $thing->parent ? $thing->parent->inv_number : null,
                condition: $thing->condition,
                balance: $thing->balance,
                auditorium_id: $thing->currentAuditorium?->auditorium?->id,
                price: $thing->price,
                is_blocked: $thing->is_blocked,
                branch_id: $thing->currentAuditorium?->auditorium?->branch_id,
            ))
            ->all();
    }

    public function form($year)
    {
        $templatePath = storage_path('excel/Form1.xls');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getSheetByName('Титул');

        /** Заполнение титульника **/

        $sheet->setCellValue('D11', 12);
        $sheet->setCellValue('D13', 31);
        $sheet->setCellValue('F11', $year);
        $sheet->setCellValue('F13', $year);
        $sheet->setCellValue('G18', Auth::user()->people->getFullFio());
        $sheet->setCellValue('G19', Auth::user()->people->phone_number);
        $sheet->setCellValue('G20', Auth::user()->email);
        //ФИО + номер телефона + эл.почта
        /** Заполнение титульника **/

        /** Заполнение основной части(ПТС) **/
        $startIndex = 9;
        $sheet = $spreadsheet->getSheetByName('ПТС');
        foreach (ThingTypeDictionary::SHORT_REPORT_TYPES as $index => $type) {
            $query = $this->thingRepository->query();
            $query = $this->thingRepository->thingTypeQuery($query, $type);
            $sheet->setCellValue('D'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year - 6,  $year)->count()); // до 6 лет
            $sheet->setCellValue('E'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year - 8, $year - 7)->count()); // от 6 до 8 лет
            $sheet->setCellValue('F'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year - 11, $year - 9)->count()); // от 8 до 11 лет
            $sheet->setCellValue('G'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, null, $year - 12)->count()); // от 11 лет
            $sheet->setCellValue('H'. ($startIndex + $index), $this->thingRepository->conditionQuery(clone $query, ConditionDictionary::BROKEN)->count()); // Неисправные ПТС
            $sheet->setCellValue('I'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year, $year)->count()); // Полученные в централизованном порядке
        }
        /** Заполнение основной части(ПТС) **/

        /** Вывод пользователю **/
        $fileName = 'short_report.xls';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xls($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function formExtended($year)
    {
        $templatePath = storage_path('excel/Form2.xls');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getSheetByName('Титул В10.1');

        /** Заполнение титульника **/
        $organization = $this->organizationRepository->getMainOrganization();

        $sheet->setCellValue('B11', $organization->name);
        $sheet->setCellValue('C13', $year);

        //$sheet->setCellValue('E22', Auth::user()->people->getFullFio());
        //$sheet->setCellValue('E23', Auth::user()->people->phone_number);
        //$sheet->setCellValue('E24', Auth::user()->email);
        //почему-то крашится генерация xls

        /** Заполнение титульника **/

        /** Заполнение основной части(ПТС) **/
        $startIndex = 16;
        $sheet = $spreadsheet->getSheetByName('Форма');
        foreach (ThingTypeDictionary::EXTENDED_REPORT_TYPES as $index => $type) {
            $query = $this->thingRepository->query();
            $query = $this->thingRepository->thingTypeQuery($query, $type);
            $sheet->setCellValue('F'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year - 5,  $year)->count()); // до 5 лет
            $sheet->setCellValue('G'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year - 7, $year - 6)->count()); // от 5 до 7 лет
            $sheet->setCellValue('H'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, $year - 10, $year - 8)->count()); // от 7 до 10 лет
            $sheet->setCellValue('I'. ($startIndex + $index), $this->thingRepository->betweenYearsQuery(clone $query, null, $year - 11)->count()); // от 10 лет
            $sheet->setCellValue('J'. ($startIndex + $index), $this->thingRepository->conditionQuery(clone $query, ConditionDictionary::FIXING)->count()); // В ремонте
        }
        /** Заполнение основной части(ПТС) **/

        /** Вывод пользователю **/
        $fileName = 'extended_report.xls';
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xls($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function resources()
    {
        // По устройствам
        $models = $this->modelRepository->getAll();
        $templatePath = storage_path('excel/Resource.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getSheetByName('По устройствам');
        $startIndex = 4;
        foreach ($models as $index => $model) {
            foreach ($model->modelResources as $resource) {
                $sheet->setCellValue('A' . ($index + $startIndex), $index + 1);
                $sheet->setCellValue('B' . ($index + $startIndex), $model->company->name);
                $sheet->setCellValue('C' . ($index + $startIndex), $model->company->name);
                $sheet->setCellValue('D' . ($index + $startIndex), $model->company->name . ' ' . $model->name);
                $sheet->setCellValue('E' . ($index + $startIndex), ResourceTypeDictionary::get($resource->resource->type));
                $sheet->setCellValue('F' . ($index + $startIndex), $resource->resource->amount);
            }
        }
        // По материальным ценностям
        $sheet = $spreadsheet->getSheetByName('По МЦ');
        $devices = $this->deviceRepository->getAll();
        foreach ($devices as $index => $device) {
            foreach ($device->model->modelResources as $resource) {
                $sheet->setCellValue('A' . ($index + $startIndex), $index + 1);
                $sheet->setCellValue('B' . ($index + $startIndex), $device->thing->name);
                $sheet->setCellValue('C' . ($index + $startIndex), $device->thing->inv_number);
                $sheet->setCellValue('D' . ($index + $startIndex), ThingTypeDictionary::get($device->thing->thing_type_id));
                $sheet->setCellValue('E' . ($index + $startIndex), $device->thing?->currentAuditorium?->auditorium?->name);
                $sheet->setCellValue('F' . ($index + $startIndex), $device->model->company->name);
                $sheet->setCellValue('G' . ($index + $startIndex), $device->model->name);
                $sheet->setCellValue('H' . ($index + $startIndex), $device->model->company->name . ' ' . $device->model->name);
                $sheet->setCellValue('I' . ($index + $startIndex), ResourceTypeDictionary::get($resource->resource->type));
                $sheet->setCellValue('J' . ($index + $startIndex), $resource->resource->amount);
            }
        }

        $fileName = 'resources.xlsx';
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function networkAudit()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('СЕТЕВОЙ ОТЧЁТ');
        $sheet->setCellValue('A1', '№');
        $sheet->setCellValue('B1', 'Инвентарный номер');
        $sheet->setCellValue('C1', 'Серийный номер');
        $sheet->setCellValue('D1', 'Тип');
        $sheet->setCellValue('E1', 'IP-адрес');
        $sheet->setCellValue('F1', 'Номер телефона');
        $sheet->setCellValue('G1', 'Аудитория');
        $sheet->setCellValue('H1', 'Отдел');
        $sheet->setCellValue('I1', 'Характеристика учёта');
        $sheet->setCellValue('J1', 'МОЛ');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $networkThings = $this->networkThingRepository->getAll();
        $index = 2;
        foreach ($networkThings as $networkThing) {
            $sheet->setCellValue('A' . $index, $index - 1);
            $sheet->setCellValue('B' . $index, $networkThing->thing->inv_number);
            $sheet->setCellValue('C' . $index, $networkThing->thing->serial_number);
            $sheet->setCellValue('D' . $index, ThingTypeDictionary::get($networkThing->thing->thing_type_id));
            $sheet->setCellValue('E' . $index, $networkThing->ip_address);
            $sheet->setCellValue('F' . $index, $networkThing->phone_number);
            $sheet->setCellValue('G' . $index, $networkThing->thing->getCurrentLocation()->name);
            $sheet->setCellValue('H' . $index, $networkThing->thing->getCurrentLocation()->branch->name);
            $sheet->setCellValue('I' . $index, ThingBalanceDictionary::get($networkThing->thing->balance));
            $sheet->setCellValue('J' . $index, $networkThing->thing->getActualMaster()?->getFullFio());
            $index++;
        }
        $fileName = 'network_audit.xlsx';
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
