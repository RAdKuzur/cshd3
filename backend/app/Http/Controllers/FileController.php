<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private FileService $fileService;
    public function __construct(
        FileService $fileService
    )
    {
        $this->fileService = $fileService;
    }

    public function all(){
        $files = $this->fileService->all();
        return response()->json([
            'success' => true,
            'data' => $files
        ]);
    }
    public function getOne($id){
        $file = $this->fileService->get($id);
        return response()->json([
            'success' => true,
            'data' => $file
        ]);
    }
    public function upload()
    {

    }
    public function download($id){
        $this->fileService->download($id);
        return response()->json([
            'success' => true
        ]);
    }

    public function delete($id){

    }
}
