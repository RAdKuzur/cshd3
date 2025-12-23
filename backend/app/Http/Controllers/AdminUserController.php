<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private UserService $userService;
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function all(){
        $data = $this->userService->getUserInfoAll();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }
    public function getOne($id){
        $data = $this->userService->getUserInfo($id);
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }

    public function create(UserRequest $request){
        $data = $request->validated();
        $this->userService->create($data);
        return response()->json([
            'success' => true,
            'code' => 200
        ]);
    }

    public function update(UserRequest $request, $id){
        $data = $request->validated();
        $this->userService->update($id, $data);
        return response()->json([
            'success' => true,
            'code' => 200
        ]);
    }


    public function delete($id){
        $this->userService->delete($id);
        return response()->json([
            'success' => true,
            'code' => 200
        ]);
    }
}
