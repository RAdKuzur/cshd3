<?php

namespace App\Http\Controllers;

use App\DTO\Thing\ThingDTO;
use App\DTO\Thing\UpdateThingDTO;
use App\Http\Requests\ThingRequest;
use App\Http\Requests\ThingRequest\StoreThingRequest;
use App\Http\Requests\ThingRequest\UpdateThingRequest;
use App\Services\ThingService;
use Illuminate\Support\Facades\Request;

class ThingController extends Controller
{
    private ThingService $thingService;
    public function __construct(
        ThingService $thingService,
    )
    {
        $this->thingService = $thingService;
    }

    public function all(){
        $data = $this->thingService->getActualAll();
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }
    public function simpleThings()
    {
        $electronics = $this->thingService->simpleThings();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ], 200);
    }
    public function electronics()
    {
        $electronics = $this->thingService->electronics();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ], 200);
    }

    public function furniture()
    {
        $electronics = $this->thingService->furniture();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ], 200);
    }

    public function personThings($id)
    {
        $data = $this->thingService->getPersonThings($id);
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function getFreeThings()
    {
        $data = $this->thingService->getFreeThings();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function transferActThings($id)
    {
        $data = $this->thingService->getTransferActThings($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function compositeCreate(StoreThingRequest $request) {
        $dto = ThingDTO::fromArray($request->validated());
        $result = $this->thingService->compositeCreate($dto);
        return response()->json([
            'success' => true,
            'data' => $result,
            'code' => 200,
        ], 201);
    }

    public function update(UpdateThingRequest $request, $id) {
        $dto = UpdateThingDTO::fromArray($request->validated());
        $this->thingService->update($id, $dto);
        return response()->json([
            'message' => $request,
            'success' => true,
            'code' => 200,
        ],200);
    }

    public function create(ThingRequest $request){
        $thing = $request->toThingDTO();
        $this->thingService->create($thing);
        return response()->json([
            'success' => true,
            'code' => 200,
        ], 201);
    }
    public function getOne($id)
    {
        $model = $this->thingService->get($id);
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $model,
        ], 200);
    }

    public function delete($id){
        $this->thingService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200,
        ], 204);
    }

    public function filterArm()
    {
        $branchId = Request::query('branchId');
        $startDate = Request::query('startDate');
        $endDate = Request::query('endDate');
        $data = $this->thingService->filterArm($branchId, $startDate, $endDate);
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }
    public function inventory($username)
    {
        $data = $this->thingService->inventory($username);
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function history($id)
    {
        $data = $this->thingService->historyThingTransferAct($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function demo()
    {
        $data = $this->thingService->demo();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
