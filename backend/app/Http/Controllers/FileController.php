<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
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
    public function upload(FileRequest $request){
        if ($request->hasFile('file')){
            $fileDTO = $request->toFileDTO();
            $file = $request->file('file');
            $this->fileService->upload($file, $fileDTO);
        }
        return response()->json([
            'success' => true,
        ]);
    }
    public function download($id){
        $this->fileService->download($id);
        return response()->json([
            'success' => true
        ]);
    }

    public function delete($id){
        $this->fileService->delete($id);
        return response()->json([
            'success' => true
        ]);
    }
}
