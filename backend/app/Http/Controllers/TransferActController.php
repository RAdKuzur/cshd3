<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferActConfirmRequest;
use App\Http\Requests\TransferActRequest;
use App\Models\TransferAct;
use App\Services\TransferActService;
use Illuminate\Http\Request;

class TransferActController extends Controller
{
    private TransferActService $transferActService;
    public function __construct(
        TransferActService $transferActService
    )
    {
        $this->transferActService = $transferActService;
    }

    public function all(){
        $transferActs = $this->transferActService->all();
        return response()->json([
            'success' => true,
            'data' => $transferActs
        ], 200);
    }
    public function getOne($id)
    {
        $transferAct = $this->transferActService->get($id);
        return response()->json([
            'success' => true,
            'data' => $transferAct
        ], 200);
    }
    public function create(TransferActRequest $request){
        $transferAct = $request->toTransferActDTO();
        $this->transferActService->create($transferAct);
        return response()->json([
            'success' => true
        ], 201);
    }
    public function update(TransferActRequest $request, $id){
        $transferAct = $request->toTransferActDTO();
        $this->transferActService->update($id, $transferAct);
        return response()->json([
            'success' => true
        ], 200);
    }
    public function delete($id){
        $this->transferActService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
    public function confirm(TransferActConfirmRequest $request)
    {
        $dto = $request->toDTO();
        $this->transferActService->confirm($dto);
        return response()->json([
            'success' => true
        ], 200);
    }

    public function cancelConfirm(TransferActConfirmRequest $request){
        $dto = $request->toDTO();
        $this->transferActService->cancelConfirm($dto);
        return response()->json([
            'success' => true
        ], 200);
    }
}
