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
        $this->reportService->thingReport();
    }
    public function auditoriums(){
        $this->reportService->allAuditoriumReport();
    }
    public function auditorium($id){
        $this->reportService->auditoriumReport($id);
    }
    public function workstations()
    {

    }
    public function general(){
        $data = $this->reportService->generalReport();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function form($year){
        $this->reportService->form($year);
        return response()->json([
            'success' => true
        ]);
    }
    public function formExtended($year){
        $this->reportService->formExtended($year);
        return response()->json([
            'success' => true
        ]);
    }
}
