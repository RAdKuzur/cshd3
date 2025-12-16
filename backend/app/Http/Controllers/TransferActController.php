<?php

namespace App\Http\Controllers;

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
}
