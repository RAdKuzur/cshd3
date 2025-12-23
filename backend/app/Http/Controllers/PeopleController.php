<?php

namespace App\Http\Controllers;

use App\Services\PeopleService;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    private PeopleService $peopleService;
    public function __construct(
        PeopleService $peopleService
    )
    {
        $this->peopleService = $peopleService;
    }
    public function all(){
        $data = $this->peopleService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function stuff(){
        $data = $this->peopleService->stuffAll();
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Инфо о персонале'
        ]);
    }
}
