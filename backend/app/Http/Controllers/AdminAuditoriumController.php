<?php

namespace App\Http\Controllers;

use App\DTO\AuditoriumDTO;
use App\Http\Requests\AuditoriumRequest;
use App\Services\AuditoriumService;
use Illuminate\Http\Request;

class AdminAuditoriumController extends Controller
{
    private AuditoriumService $auditoriumService;
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
        ], 200);
    }

    public function create(AuditoriumRequest $request){
        $auditoriumDTO = $request->toDTO();
        $this->auditoriumService->create($auditoriumDTO);
        return response()->json([
            'success' => true,
            'code' => 200,
        ], 201);
    }
    public function update(AuditoriumRequest $request, $id){
        $auditoriumDTO = $request->toDTO();
        $this->auditoriumService->update($id, $auditoriumDTO);
        return response()->json([
            'success' => true,
            'code' => 200,
        ], 200);
    }
    public function delete($id){
        $this->auditoriumService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200,
        ], 204);
    }
}
