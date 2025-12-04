<?php

namespace App\Http\Controllers;

use App\Services\ThingService;
use Illuminate\Http\Request;

class ElectronicsController extends Controller
{
    public ThingService $thingService;
    public function __construct(ThingService $thingService){
        $this->thingService = $thingService;
    }
    public function simpleElectronics()
    {
        $electronics = $this->thingService->simpleElectronics();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ]);
    }
    public function electronics()
    {
        $electronics = $this->thingService->electronics();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ]);
    }
}
