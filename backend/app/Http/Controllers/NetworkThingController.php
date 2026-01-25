<?php

namespace App\Http\Controllers;


use App\Http\Requests\NetworkThingRequest;
use App\Services\NetworkThingService;

class NetworkThingController extends Controller
{
    private NetworkThingService $networkThingService;
    public function __construct(
        NetworkThingService $networkThingService
    )
    {
        $this->networkThingService = $networkThingService;
    }


    public function all(){
        $data = $this->networkThingService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getOne($id){
        $data = $this->networkThingService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function create(NetworkThingRequest $request){
        $dto = $request->toDTO();
        $this->networkThingService->create($dto);
        return response()->json([
            'success' => true
        ]);
    }
    public function update($id, NetworkThingRequest $request){
        $dto = $request->toDTO();
        $this->networkThingService->update($id, $dto);
        return response()->json([
            'success' => true
        ]);
    }
    public function delete($id){
        $this->networkThingService->delete($id);
        return response()->json([
            'success' => true
        ]);
    }

    public function telephones()
    {
        $data = $this->networkThingService->telephonesAll();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
