<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $user = $this->userRepository->getByEmail($data['email']);
        if ($user && Hash::check($data['password'], $user->password)) {
            $tokens = $this->authService->login($user);
            return response()->json([
                'success' => true,
                'message' => 'Успешный вход',
                'username' => $user->username,
                'fio' => $user->people->getFullFio(),
                'position' => $user->people->getPosition()->name,
                'role' => $user->role,
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
    public function forgotPassword(Request $request)
    {

    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if ($this->authService->validateToken($refreshToken)) {
            $refreshData = $this->authService->refresh($refreshToken);
            return response()->json([
                'success' => true,
                'message' => 'Успешный вход',
                'username' => $refreshData['username'],
                'fio' => $refreshData['fio'],
                'position' => $refreshData['position'],
                'role' => $refreshData['role'],
            ])
                ->cookie('refresh_token', $refreshData['refreshToken'], (int)env('REFRESH_TOKEN_TIME'))
                ->cookie('access_token', $refreshData['accessToken'], (int)env('ACCESS_TOKEN_TIME'));
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Пустой refresh_token или неверный'
            ], 401);
        }

    }
    public function logout(Request $request){
        $refreshToken = $request->cookie('refresh_token');
        $this->authService->logout($refreshToken);
        return response()->json([
            'success' => true,
            'message' => 'Выход их системы'
        ])
            ->cookie('refresh_token', '', 0)
            ->cookie('access_token', '',0);
    }
}
