<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Test")]
class TestController extends Controller
{
    //
    #[OA\Get(
        path: "/api/test",
        summary: "Test endpoint",
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "string")
                    ]
                )
            )
        ]
    )]

    public function test(){

        return response()->json([
            'data' => 'Test endpoint'
        ], 200);
    }
    public function tests(){
        return response()->json([
            'data' => 'Tests endpoint'
        ], 200);
    }
}
