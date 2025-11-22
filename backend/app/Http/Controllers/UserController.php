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

    public function profile(Request $request){
        $accessToken = $request->cookie('access_token');
        $userId = JWTAuth::setToken($accessToken)->getPayload()['user_id'];
        $userInfo = $this->userService->getProfileInfo($userId);

    }
}
