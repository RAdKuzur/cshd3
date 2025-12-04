<?php

namespace App\Http\Controllers;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Http\Requests\ThingRequest;
use App\Repositories\ThingRepository;
use App\Services\ThingService;

class ThingController extends Controller
{
    private ThingService $thingService;
    public function __construct(
        ThingService $thingService
    )
    {
        $this->thingService = $thingService;
    }

    public function create(ThingRequest $request){
        $data = $request->validated();
        $this->thingService->create($data);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function view($id)
    {
        $model = $this->thingService->get($id);
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $model,
        ]);
    }
    public function edit($id){
        $model = $this->thingService->get($id);
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $model,
        ]);
    }
    public function update(ThingRequest $request, $id)
    {
        $data = $request->validated();
        $this->thingService->update($id, $data);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
    public function delete($id){
        $this->thingService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
}
