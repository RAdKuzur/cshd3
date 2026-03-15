<?php

namespace App\Http\Controllers;


use App\Http\Requests\HistoryResourceRequest;
use App\Services\HistoryResourceService;

class HistoryResourceController extends Controller
{
    private HistoryResourceService $historyResourceService;
    public function __construct(
        HistoryResourceService $historyResourceService
    )
    {
        $this->historyResourceService = $historyResourceService;
    }

    public function all() {
        $data = $this->historyResourceService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function getOne($id) {
        $data = $this->historyResourceService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function create(HistoryResourceRequest $request) {
        $historyResourceDTO = $request->toDTO();
        $this->historyResourceService->create($historyResourceDTO);
        return response()->json([
            'success' => true
        ], 201);
    }

    public function update(HistoryResourceRequest $request, $id) {
        $historyResourceDTO = $request->toDTO();
        $this->historyResourceService->update($id, $historyResourceDTO);
        return response()->json([
            'success' => true
        ], 200);
    }
    public function delete($id) {
        $this->historyResourceService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
}
