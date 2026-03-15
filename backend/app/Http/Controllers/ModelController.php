<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelRequest;
use App\Services\ModelService;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    private ModelService $modelService;
    public function __construct(
        ModelService $modelService
    )
    {
        $this->modelService = $modelService;
    }

    public function all()
    {
        $data = $this->modelService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function getOne($id) {
        $data = $this->modelService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function create(ModelRequest $request) {
        $this->modelService->create($request->toDTO());
        return response()->json([
            'success' => true
        ], 201);
    }
    public function update(ModelRequest $request, $id) {
        $this->modelService->update($id, $request->toDTO());
        return response()->json([
            'success' => true
        ], 200);
    }
    public function delete($id) {
        $this->modelService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
}
