<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuditoriumResponsibilityRequest;
use App\Services\AuditoriumResponsibilityService;
use Illuminate\Http\Request;

class AuditoriumResponsibilityController extends Controller
{
    private AuditoriumResponsibilityService $auditoriumResponsibilityService;
    public function __construct(
        AuditoriumResponsibilityService $auditoriumResponsibilityService
    )
    {
        $this->auditoriumResponsibilityService = $auditoriumResponsibilityService;
    }

    public function all() {
        $data = $this->auditoriumResponsibilityService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function getOne($id) {
        $data = $this->auditoriumResponsibilityService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function create(AuditoriumResponsibilityRequest $request) {
        $auditoriumResponsibilityDTO = $request->toDTO();
        $this->auditoriumResponsibilityService->create($auditoriumResponsibilityDTO);
        return response()->json([
            'success' => true
        ], 201);
    }

    public function update(AuditoriumResponsibilityRequest $request, $id) {
        $auditoriumResponsibilityDTO = $request->toDTO();
        $this->auditoriumResponsibilityService->update($id, $auditoriumResponsibilityDTO);
        return response()->json([
            'success' => true
        ], 200);
    }

    public function delete($id) {
        $this->auditoriumResponsibilityService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
}
