<?php

namespace App\Http\Controllers;


use App\Events\TransferActCreated;
use App\Http\Requests\TestRequest;
use App\Http\Requests\TestsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(Request $request){
        $user = User::find(1);
        TransferActCreated::dispatch($user);
        return response()->json([
            'data' => $user->username
        ]);
    }
    public function tests(TestsRequest $request){
        $data = $request->toDTOs();
        return response()->json([
            'data' => $data
        ]);
    }
}
