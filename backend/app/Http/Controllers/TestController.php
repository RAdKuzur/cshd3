<?php

namespace App\Http\Controllers;


use App\Http\Requests\TestRequest;
use App\Http\Requests\TestsRequest;

class TestController extends Controller
{
    //
    public function test(TestRequest $request){

        $data = $request->toDTO();
        return response()->json([
            'data' => $data
        ]);
    }
    public function tests(TestsRequest $request){
        $data = $request->toDTOs();
        return response()->json([
            'data' => $data
        ]);
    }
}
