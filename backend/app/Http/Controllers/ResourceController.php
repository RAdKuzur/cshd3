<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Services\ResourceService;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    private ResourceService $resourceService;
    public function __construct(
        ResourceService $resourceService
    )
    {
        $this->resourceService = $resourceService;
    }

    public function all()
    {
        $data = $this->resourceService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function getOne($id) {
        $data = $this->resourceService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function create(ResourceRequest $request) {
        $this->resourceService->create($request->toDTO());
        return response()->json([
            'success' => true
        ], 201);
    }
    public function update(ResourceRequest $request, $id) {
        $this->resourceService->update($id, $request->toDTO());
        return response()->json([
            'success' => true
        ], 200);
    }
    public function delete($id) {
        $this->resourceService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
}
