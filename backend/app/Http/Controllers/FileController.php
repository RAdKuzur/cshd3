<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Requests\ImportFileRequest;
use App\Services\FileService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Files")]
class FileController extends Controller
{
    private FileService $fileService;
    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }
    #[OA\Get(
        path: "/api/files",
        summary: "Список файлов",
        tags: ["Files"],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "table_name", type: "string", example: "table_name"),
                                    new OA\Property(property: "row_id", type: "string", example: "1"),
                                    new OA\Property(property: "filepath", type: "string"),
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function all()
    {
        $files = $this->fileService->all();
        return response()->json([
            'success' => true,
            'data' => $files
        ]);
    }
    #[OA\Get(
        path: "/api/files/{id}",
        summary: "Получить файл по id",
        tags: ["Files"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean"),
                        new OA\Property(
                            property: "data",
                            properties: [
                                new OA\Property(property: "id", type: "integer"),
                                new OA\Property(property: "table_name", type: "string"),
                                new OA\Property(property: "row_id", type: "integer"),
                                new OA\Property(property: "filepath", type: "string"),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 404, description: "File not found")
        ]
    )]
    public function getOne($id)
    {
        $file = $this->fileService->get($id);
        return response()->json([
            'success' => true,
            'data' => $file
        ]);
    }
    #[OA\Post(
        path: "/api/import-files",
        summary: "Импорт данных файла",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["table_name","row_id","filepath"],
                properties: [
                    new OA\Property(property: "table_name", type: "string", example: "table_name"),
                    new OA\Property(property: "row_id", type: "integer", example: 1),
                    new OA\Property(property: "filepath", type: "string"),
                ]
            )
        ),
        tags: ["Files"],
        responses: [
            new OA\Response(response: 200, description: "success"),
        ]
    )]

    public function importUpload(ImportFileRequest $request) {
        $fileDTO = $request->toDTO();
        $this->fileService->importUpload($fileDTO);
        return response()->json([
            'success' => true
        ]);
    }
    #[OA\Delete(
        path: "/api/import-files/{id}",
        summary: "Удалить данные о файле",
        tags: ["Files"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "success"),
        ]
    )]

    public function importDelete($id)
    {
        $this->fileService->importDelete($id);
        return response()->json([
            'success' => true
        ]);
    }
    public function upload(FileRequest $request)
    {
        $fileDTO = $request->toFileDTO();
        $this->fileService->upload($fileDTO);
        return response()->json(['success' => true]);
    }
    public function download($id)
    {
        return $this->fileService->download($id);
    }

    public function delete($id)
    {
        $this->fileService->delete($id);
        return response()->json([
            'success' => true
        ]);
    }
}
