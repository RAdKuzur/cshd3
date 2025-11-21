<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    private AuthService $authService;
    public function __construct(
        UserRepository $userRepository,
        AuthService $authService
    ){
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }
    /* @var User $user */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $login = $data['login'];
        $password = $data['password'];
        $user = $this->userRepository->getByEmail($login);
        if ($user && Hash::check($password, $user->password)) {
            $tokens = $this->authService->login($user);
            return response()->json([
                'success' => true,
                'message' => 'Успешный вход',
            ])
                ->cookie('refresh_token', $tokens['refreshToken'], (int)env('REFRESH_TOKEN_TIME'))
                ->cookie('access_token', $tokens['accessToken'], (int)env('ACCESS_TOKEN_TIME'));
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Неверный логин и/или пароль'
            ], 401);
        }
    }
    public function check(Request $request)
    {
        $accessToken = $request->cookie('access_token');
        $refreshToken = $request->cookie('refresh_token');
        if ($this->authService->isAuth($accessToken, $refreshToken)) {
            $tokens = $this->authService->refresh($refreshToken);
            return response()->json([
                'success' => true,
            ])
            ->cookie('refresh_token', $tokens['refreshToken'], (int)env('REFRESH_TOKEN_TIME'))
            ->cookie('access_token', $tokens['accessToken'], (int)env('ACCESS_TOKEN_TIME'));
        }
        return response()->json([
            'success' => false,
            'refresh_token' => $refreshToken,
            'access_token' => $accessToken,
        ], 401);
    }
    public function forgotPassword(Request $request)
    {

    }
    public function logout(Request $request){

    }
    public function refresh(Request $request){

    }
}
