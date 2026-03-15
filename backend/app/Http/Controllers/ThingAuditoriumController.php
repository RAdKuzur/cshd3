<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThingAuditoriumRequest;
use App\Services\ThingAuditoriumService;
use Illuminate\Http\Request;

class ThingAuditoriumController extends Controller
{
    private ThingAuditoriumService $thingAuditoriumService;
    public function __construct(
        ThingAuditoriumService $thingAuditoriumService
    )
    {
        $this->thingAuditoriumService = $thingAuditoriumService;
    }

    public function all() {
        $data = $this->thingAuditoriumService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function getOne($id) {
        $data = $this->thingAuditoriumService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function create(ThingAuditoriumRequest $request) {
        $thingAuditoriumDTO = $request->toDTO();
        $this->thingAuditoriumService->create($thingAuditoriumDTO);
        return response()->json([
            'success' => true
        ], 201);
    }

    public function update(ThingAuditoriumRequest $request, $id) {
        $thingAuditoriumDTO = $request->toDTO();
        $this->thingAuditoriumService->update($id, $thingAuditoriumDTO);
        return response()->json([
            'success' => true
        ], 200);
    }

    public function delete($id) {
        $this->thingAuditoriumService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
}
