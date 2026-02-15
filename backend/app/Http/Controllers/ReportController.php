<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private ReportService $reportService;
    public function __construct(
        ReportService $reportService
    )
    {
        $this->reportService = $reportService;
    }
    public function things(){
        return $this->reportService->thingReport();
    }
    public function auditoriums(){
        return $this->reportService->allAuditoriumReport();
    }
    public function auditorium($id){
        return $this->reportService->auditoriumReport($id);
    }
    public function general(){
        $data = $this->reportService->generalReport();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function form($year){
        return $this->reportService->form($year);
    }
    public function formExtended($year){
        return $this->reportService->formExtended($year);
    }
}
