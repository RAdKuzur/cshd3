<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Services\BranchService;

class AdminBranchController extends Controller
{
    private BranchService $branchService;
    public function __construct(
        BranchService $branchService
    )
    {
        $this->branchService = $branchService;
    }

    public function all(){
        $data = $this->branchService->all();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }
    public function getOne($id){
        $data = $this->branchService->getOne($id);
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }
    public function create(BranchRequest $request){
        $branch = $request->toDTO();
        $this->branchService->create($branch->toArray());
        return response()->json([
            'success' => true,
            'code' => 200
        ]);
    }
    public function update(BranchRequest $request, $id){
        $branch = $request->toDTO();
        $this->branchService->update($id, $branch->toArray());
        return response()->json([
            'success' => true,
            'code' => 200
        ]);
    }
    public function delete($id){
        $this->branchService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200
        ]);
    }
}
