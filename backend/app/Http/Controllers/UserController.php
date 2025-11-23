<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function profile($username){
        $data = $this->userService->getProfileInfo(
            $username
        );
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Инфо о профиле'
        ]);
    }
}
