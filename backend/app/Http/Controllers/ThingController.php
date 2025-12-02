<?php

namespace App\Http\Controllers;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Repositories\ThingRepository;
use App\Services\ThingService;
use Illuminate\Http\Request;

class ThingController extends Controller
{
    private ThingService $thingService;
    public function __construct(
        ThingRepository $thingRepository,
        ThingService $thingService
    )
    {
        $this->thingService = $thingService;
    }

    public function infoType(){
        $types = ThingTypeDictionary::type();
        $conditions = ConditionDictionary::type();
        return response()->json([
            'success' => true,
            'code' => 200,
            'types' => json_decode(json_encode($types, JSON_FORCE_OBJECT)),
            'conditions' => json_decode(json_encode($conditions, JSON_FORCE_OBJECT)),
        ]);
    }

    public function simpleElectronics()
    {
        $electronics = $this->thingService->simpleElectronics();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ]);
    }
    public function electronics()
    {
        $electronics = $this->thingService->electronics();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $electronics,
        ]);
    }
    public function create(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'inv_number' => 'required',
            'serial_number' => 'required',
            'operation_date' => 'required',
            'thing_type_id' => 'required',
            'condition' => 'required',
            'thing_parent_id' => 'nullable',
            'price' => 'required',
            'comment' => 'nullable',
            'auditorium_id' => 'required',
        ]);
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
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'inv_number' => 'nullable',
            'serial_number' => 'nullable',
            'operation_date' => 'required',
            'thing_type_id' => 'required',
            'condition' => 'required',
            'thing_parent_id' => 'nullable',
            'price' => 'required',
            'comment' => 'nullable',
            'auditorium_id' => 'required',
        ]);
        $this->thingService->update($id, $data);
        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
}
