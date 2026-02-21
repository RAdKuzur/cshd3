<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeoplePositionRequest;
use App\Services\PeoplePositionService;

class PeoplePositionController extends Controller
{
    private PeoplePositionService $peoplePositionService;
    public function __construct(
        PeoplePositionService $peoplePositionService
    )
    {
        $this->peoplePositionService = $peoplePositionService;
    }

    public function all() {
        $data = $this->peoplePositionService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getOne($id) {
        $data = $this->peoplePositionService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function create(PeoplePositionRequest $request) {
        $thingAuditoriumDTO = $request->toDTO();
        $this->peoplePositionService->create($thingAuditoriumDTO);
        return response()->json([
            'success' => true
        ]);
    }

    public function update(PeoplePositionRequest $request, $id) {
        $thingAuditoriumDTO = $request->toDTO();
        $this->peoplePositionService->update($id, $thingAuditoriumDTO);
        return response()->json([
            'success' => true
        ]);
    }

    public function delete($id) {
        $this->peoplePositionService->delete($id);
        return response()->json([
            'success' => true
        ]);
    }
}
