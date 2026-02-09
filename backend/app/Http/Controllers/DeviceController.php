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
        ]);
    }
    public function getOne($id) {
        $data = $this->deviceService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function create(DeviceRequest $request) {
        $this->deviceService->create($request->toDTO());
        return response()->json([
            'success' => true,
        ]);
    }
    public function update(DeviceRequest $request, $id) {
        $this->deviceService->update($id, $request->toDTO());
        return response()->json([
            'success' => true,
        ]);
    }
    public function delete($id) {
        $this->deviceService->delete($id);
        return response()->json([
            'success' => true,
        ]);
    }
}
