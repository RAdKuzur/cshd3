<?php

namespace App\Http\Controllers;

use App\Helpers\Auth;
use App\Http\Requests\BlockRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\FileService;
use App\Services\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    private AuthService $authService;
    private RedisService $redisService;
    private FileService $fileService;
    public function __construct(
        UserRepository $userRepository,
        AuthService $authService,
        RedisService $redisService,
        FileService $fileService
    ){
        $this->userRepository = $userRepository;
        $this->authService = $authService;
        $this->redisService = $redisService;
        $this->fileService = $fileService;
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
                'position' => $user->people->getPosition() ? $user->people->getPosition()->name : null,
                'role' => $user->role,
                'icon_link' => $this->fileService->getAvatarLink($user->id)
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
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->email();
        $this->authService->forgotPassword($email);
        return response()->json([
            'success' => true,
        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $dto = $request->toDTO();
        $this->authService->changePassword($dto);
        return response()->json([
            'success' => true,
        ]);
    }
    public function block(BlockRequest $request)
    {
        $dto = $request->toDTO();
        $this->redisService->set(
            $dto->url,
            Auth::user()->id,
            env('BLOCK_PAGE_TIME') * 60);
        return response()->json([
            'success' => true
        ]);
    }
    public function unblock(BlockRequest $request){
        $dto = $request->toDTO();
        $this->redisService->del($dto->url);
        return response()->json([
            'success' => true
        ]);
    }
    public function refresh(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if ($this->authService->validateRefreshToken($refreshToken)) {
            $refreshData = $this->authService->refresh($refreshToken);
            return response()->json([
                'success' => true,
                'message' => 'Успешный вход',
                'username' => $refreshData['username'],
                'fio' => $refreshData['fio'],
                'role' => $refreshData['role'],
                'icon_link' => $refreshData['icon_link'],
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
