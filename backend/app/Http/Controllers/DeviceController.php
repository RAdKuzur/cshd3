<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    private DeviceService $deviceService;
    public function __construct(
        DeviceService $deviceService
    )
    {
        $this->deviceService = $deviceService;
    }

    public function all()
    {
        $data = $this->deviceService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function getOne($id) {
        $data = $this->deviceService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function create(DeviceRequest $request) {
        $this->deviceService->create($request->toDTO());
        return response()->json([
            'success' => true,
        ], 201);
    }
    public function update(DeviceRequest $request, $id) {
        $this->deviceService->update($id, $request->toDTO());
        return response()->json([
            'success' => true,
        ], 200);
    }
    public function delete($id) {
        $this->deviceService->delete($id);
        return response()->json([
            'success' => true,
        ], 204);
    }
}
