<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelResourceRequest;
use App\Services\ModelResourceService;

class ModelResourceController extends Controller
{
    private ModelResourceService $modelResourceService;
    public function __construct(
        ModelResourceService $modelResourceService
    )
    {
        $this->modelResourceService = $modelResourceService;
    }

    public function all() {
        $data = $this->modelResourceService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function getOne($id) {
        $data = $this->modelResourceService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function create(ModelResourceRequest $request) {
        $this->modelResourceService->create($request->toDTO());
        return response()->json([
            'success' => true
        ], 201);
    }

    public function update(ModelResourceRequest $request, $id) {
        $this->modelResourceService->update($id, $request->toDTO());
        return response()->json([
            'success' => true
        ], 200);
    }

    public function delete($id) {
        $this->modelResourceService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }

}
