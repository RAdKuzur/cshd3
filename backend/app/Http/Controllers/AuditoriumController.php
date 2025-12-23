<?php

namespace App\Http\Controllers;

use App\Services\AuditoriumService;
use Illuminate\Http\Request;

class AuditoriumController extends Controller
{
    public AuditoriumService $auditoriumService;
    public function __construct(
        AuditoriumService $auditoriumService
    )
    {
        $this->auditoriumService = $auditoriumService;
    }

    public function all(){
        $data = $this->auditoriumService->all();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }
    public function map(){
        $data = $this->auditoriumService->map();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }
}
