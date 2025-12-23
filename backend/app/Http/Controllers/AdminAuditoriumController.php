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
        ]);
    }

    public function create(AuditoriumRequest $request){
        $data = $request->validated();
        $auditoriumDTO = AuditoriumDTO::fromArray($data);
        $this->auditoriumService->create($auditoriumDTO);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function update(AuditoriumRequest $request, $id){
        $data = $request->validated();
        $auditoriumDTO = AuditoriumDTO::fromArray($data);
        $this->auditoriumService->update($id, $auditoriumDTO);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function delete($id){
        $this->auditoriumService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
}
