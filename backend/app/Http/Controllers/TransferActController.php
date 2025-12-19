<?php

namespace App\Http\Controllers;

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

    public function index(){
        $transferActs = $this->transferActService->index();
        return response()->json([
            'success' => true,
            'data' => $transferActs
        ]);
    }
    public function view($id)
    {
        $transferAct = $this->transferActService->get($id);
        return response()->json([
            'success' => true,
            'data' => $transferAct
        ]);
    }
    public function edit($id)
    {
        $transferAct = $this->transferActService->get($id);
        return response()->json([
            'success' => true,
            'data' => $transferAct
        ]);
    }
    public function store(TransferActRequest $request){
        $transferAct = $request->toTransferActDTO();
        $this->transferActService->create($transferAct);
        return response()->json([
            'success' => true
        ]);
    }
    public function update(TransferActRequest $request, $id){
        return response()->json([
            'success' => true
        ]);
    }
    public function delete($id){
        return response()->json([
            'success' => true
        ]);
    }
}
