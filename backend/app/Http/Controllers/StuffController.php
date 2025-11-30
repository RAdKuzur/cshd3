<?php

namespace App\Http\Controllers;

use App\Services\StuffService;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    private StuffService $stuffService;
    public function __construct(
        StuffService $stuffService
    )
    {
        $this->stuffService = $stuffService;
    }

    public function stuff(){
        $data = $this->stuffService->stuffAll();
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Инфо о персонале'
        ]);
    }
}
