<?php

namespace App\Http\Controllers;

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

    public function index(){
        $data = $this->auditoriumService->index();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }

    public function store(AuditoriumRequest $request){
        $data = $request->validated();
        $this->auditoriumService->create($data);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function update(AuditoriumRequest $request, $id){
        $data = $request->validated();
        $this->auditoriumService->update($id, $data);
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
