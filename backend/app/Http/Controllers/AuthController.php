<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    private UserRepository $userRepository;
    public function __construct(
        UserRepository $userRepository,
    ){
        $this->userRepository = $userRepository;
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRepository->getByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => 'false',
            ], 401);
        }
        $token = $user->createToken('access_token', ['*'], now()->addMinutes((int)env('ACCESS_TOKEN_TIME')))->plainTextToken;
        return response()->json([
            'success' => 'true',
            'username' => $user->username,
            'fio' => $user->username,
            'token' => $token,
        ]);
    }
    public function forgotPassword(Request $request)
    {

    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        // или $request->user()->currentAccessToken()->delete(); если хотим удалить последний access_token
        return response()->json([
            'success' => 'true',
        ]);
    }
}
