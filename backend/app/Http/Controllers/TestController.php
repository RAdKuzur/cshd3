<?php

namespace App\Http\Controllers;


use App\Events\TransferActCreated;
use App\Http\Requests\TestRequest;
use App\Http\Requests\TestsRequest;
use App\Jobs\TestJob;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(Request $request){
        TestJob::dispatch()->onConnection('rabbitmq')->onQueue('test-queue');
        return response()->json([
            'data' => 'OK!!!'
        ]);
    }
    public function tests(TestsRequest $request){
        $data = $request->toDTOs();
        return response()->json([
            'data' => $data
        ]);
    }
}
