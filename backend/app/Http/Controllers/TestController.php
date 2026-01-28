<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(){

        return response()->json([
            'data' => 'Test endpoint'
        ]);
    }
    public function tests(){
        return response()->json([
            'data' => 'Tests endpoint'
        ]);
    }
}
