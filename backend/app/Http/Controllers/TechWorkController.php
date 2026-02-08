<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechWorkRequest;
use App\Services\TechWorkService;

class TechWorkController extends Controller
{
    private TechWorkService $techWorkService;
    public function __construct(
        TechWorkService $techWorkService
    )
    {
        $this->techWorkService = $techWorkService;
    }
    public function all() {
        $data = $this->techWorkService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function create(TechWorkRequest $request) {
        $dto = $request->toDTO();
        $this->techWorkService->create($dto);
        return response()->json([
            'success' => true,
        ]);
    }

    public function cancel($id) {
        $this->techWorkService->cancel($id);
        return response()->json([
            'success' => true
        ]);
    }
}
