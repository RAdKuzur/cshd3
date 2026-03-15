<?php

namespace App\Http\Controllers;

use App\Services\TokenService;

class TokenController extends Controller
{
    private TokenService $tokenService;
    public function __construct(
        TokenService $tokenService
    )
    {
        $this->tokenService = $tokenService;
    }

    public function all() {
        $data = $this->tokenService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function revoke($id) {
        $this->tokenService->revoke($id);
        return response()->json([
            'success' => true
        ], 200);
    }

    public function delete($id) {
        $this->tokenService->delete($id);
        return response()->json([
            'success' => true
        ], 204);
    }
    public function allUsername($username) {
        $data = $this->tokenService->allUsername($username);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
