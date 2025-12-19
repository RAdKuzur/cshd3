<?php

namespace App\Http\Controllers;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\DTO\ThingDTO;
use App\Http\Requests\StoreThingRequest;
use App\Http\Requests\ThingRequest;
use App\Models\Thing;
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

    public function index(){
        $data = $this->thingService->getActualAll();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function personThings($id)
    {
        $data = $this->thingService->getPersonThings($id);
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function free()
    {
        $data = $this->thingService->free();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function transferActThings($id)
    {
        $data = $this->thingService->getTransferActThings($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function compositeStore(StoreThingRequest $request) {
        $dto = ThingDTO::fromArray($request->validated());
        $result = $this->thingService->compositeCreate($dto);

        return response()->json(
            [
                'message' => $result,
                'success' => true,
                'code' => 200,
            ]
        );
    }

    public function store(ThingRequest $request){
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
