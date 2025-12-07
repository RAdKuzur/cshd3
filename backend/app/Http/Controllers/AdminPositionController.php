<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Services\PositionService;
use Illuminate\Http\Request;

class AdminPositionController extends Controller
{
    private PositionService $positionService;
    public function __construct(
        PositionService $positionService
    )
    {
        $this->positionService = $positionService;
    }

    public function index(){
        $data = $this->positionService->index();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }

    public function store(PositionRequest $request){
        $data = $request->validated();
        $this->positionService->create($data);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function update(PositionRequest $request, $id){
        $data = $request->validated();
        $this->positionService->update($id, $data);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function delete($id){
        $this->positionService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
}
