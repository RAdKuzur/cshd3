<?php

namespace App\Services;

use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Repositories\AuditoriumRepository;
use App\Repositories\OrganizationRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;

class ReportService
{
    public AuditoriumRepository $auditoriumRepository;
    public OrganizationRepository $organizationRepository;
    public function __construct(
        AuditoriumRepository $auditoriumRepository,
        OrganizationRepository $organizationRepository
    )
    {
        $this->auditoriumRepository = $auditoriumRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function auditoriumReport($id)
    {
        $auditorium = $this->auditoriumRepository->get($id);
        $phpWord = new PhpWord();
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'allCaps' => true], ['align' => 'center']);
        $phpWord->addParagraphStyle('center', ['align' => 'center']);
        $phpWord->addParagraphStyle('centerItalic', ['align' => 'center']);
        $phpWord->addFontStyle('italic14', ['italic' => true, 'size' => 12]);
        $section = $phpWord->addSection();
        $section->addText($auditorium->branch->organization->name , ['size' => 14], ['align' => 'center']);
        $section->addText($auditorium->branch->organization->address, ['italic' => true, 'size' => 12], ['align' => 'center']);
        $section->addText('ПАСПОРТ КАБИНЕТА', ['bold' => true, 'size' => 14, 'allCaps' => true], ['align' => 'center']);
        $section->addText('Кабинет № ' . $auditorium->name,  ['italic' => true, 'size' => 12], ['align' => 'center']);
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
        if(count($auditorium->things) > 0){
            $table->addRow();
            $table->addCell($wNum)->addText('№', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addCell($wName)->addText('Наименование', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addCell($wCount)->addText('Кол-во', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $table->addCell($wInv)->addText('Инвентарный номер', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            foreach ($auditorium->things as $index => $item) {
                $table->addRow();
                $table->addCell($wNum)->addText($index + 1, ['size' => 12], ['alignment' => Jc::CENTER]);
                $table->addCell($wName)->addText($item->name, ['size' => 12]);
                $table->addCell($wCount)->addText(
                    $item->count ?? 1,
                    ['size' => 14],
                    ['alignment' => Jc::CENTER]
                );

                $table->addCell($wInv)->addText($item->inv_number, ['size' => 12], ['alignment' => Jc::CENTER]);
            }
        }
        else {
            $section->addText('В ПОМЕЩЕНИИ НИЧЕГО НЕТ' , ['size' => 14], ['align' => 'center']);
        }
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=auditorium_report.docx');
        $writer->save('php://output');
        exit;
    }
    public function allAuditoriumReport()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
        $auditoriums = $this->auditoriumRepository->getAll();
        if (empty($auditoriums)) {
            header('Content-Type: text/html; charset=utf-8');
            echo "Нет данных для отчета";
            exit;
        }
        $organization = $this->organizationRepository->getMainOrganization();
        $phpWord = new PhpWord();
        $phpWord->getSettings()->setUpdateFields(true);
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'allCaps' => true], ['align' => 'center']);
        $phpWord->addParagraphStyle('center', ['align' => 'center']);
        $phpWord->addFontStyle('italic14', ['italic' => true, 'size' => 12]);
        $section = $phpWord->addSection();
        $section->addText($organization->name, ['size' => 14], ['align' => 'center']);
        $section->addText($organization->address, ['italic' => true, 'size' => 12], ['align' => 'center']);
        $section->addText('ОБЩИЙ ПАСПОРТ КАБИНЕТОВ',
            ['bold' => true, 'size' => 14, 'allCaps' => true],
            ['align' => 'center']
        );
        $section->addTextBreak();
        foreach ($auditoriums as $auditorium) {
            $section->addTextBreak();
            $section->addText('Кабинет № ' . $auditorium->name,
                ['italic' => true, 'size' => 12],
                ['align' => 'center']
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
            if (count($auditorium->things) > 0) {
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
                foreach ($auditorium->things as $index => $item) {
                    $table->addRow();
                    $table->addCell($wNum)->addText($index + 1,
                        ['size' => 12],
                        ['alignment' => Jc::CENTER]
                    );
                    $table->addCell($wName)->addText($item->name, ['size' => 12]);
                    $table->addCell($wCount)->addText(
                        $item->count ?? 1,
                        ['size' => 12],
                        ['alignment' => Jc::CENTER]
                    );
                    $table->addCell($wInv)->addText(
                        $item->inv_number ?? '-',
                        ['size' => 12],
                        ['alignment' => Jc::CENTER]
                    );
                }
            } else {
                $section->addText('В кабинете нет оборудования',
                    ['size' => 12, 'italic' => true],
                    ['align' => 'center']
                );
            }
            unset($table);
        }
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=general_auditorium_report.docx');
        $writer->save('php://output');
        exit;
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
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $writer = new Xlsx($spreadsheet);
        $index = 2;
        foreach ($organization->departments as $department) {
            foreach ($department->auditoriums as $auditorium) {
                foreach ($auditorium->things as $thing) {
                    $sheet->setCellValue('A' . $index, $index - 1);
                    $sheet->setCellValue('B' . $index, $thing->name);
                    $sheet->setCellValue('C' . $index, $thing->inv_number);
                    $sheet->setCellValue('D' . $index, ThingTypeDictionary::get($thing->thing_type_id));
                    $sheet->setCellValue('E' . $index, ThingBalanceDictionary::get($thing->balance));
                    $sheet->setCellValue('F' . $index, $thing->operation_date);
                    $sheet->setCellValue('G' . $index, $thing->price);
                    $sheet->setCellValue('H' . $index, $auditorium->name);
                    $index++;
                }
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=thing_report.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
