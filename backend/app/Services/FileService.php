<?php

namespace App\Services;

use App\DTO\FileDTO;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public FileRepository $fileRepository;
    public function __construct(
        FileRepository $fileRepository
    )
    {
        $this->fileRepository = $fileRepository;
    }

    public function all() : array {
        $data = [];
        $files = $this->fileRepository->getAll();
        foreach ($files as $file){
            $data[] = FileDTO::fromModel($file);
        }
        return $data;
    }
    public function get($id) : FileDTO
    {
        $file = $this->fileRepository->get($id);
        return new FileDTO(
            table_name: $file->table_name,
            row_id: $file->row_id,
            filepath: $file->filepath,
        );
    }
    public function upload($file, FileDTO $fileDTO)
    {
        if($this->fileRepository->isPossibleToUpload($fileDTO->table_name, $fileDTO->row_id)) {
            DB::beginTransaction();
            try {
                $filename = $this->generateUniqueName($file->getClientOriginalName());
                $this->fileRepository->create([
                    'table_name' => $fileDTO->table_name,
                    'row_id' => $fileDTO->row_id,
                    'filepath' => base_path() . '/storage/app/public/uploads/' . $filename
                ]);
                DB::commit();
                if (!file_exists(base_path() . '/storage/app/public/uploads')) {
                    mkdir(base_path() . '/storage/app/public/uploads', 0777, true);
                }
                $file->move(base_path() . '/storage/app/public/uploads/', $filename);
            } catch (\Exception $exception) {
                Log::debug($exception->getMessage());
                DB::rollBack();
            }
        }
    }
    public function download($id) {
        $file = $this->fileRepository->get($id);
        if (file_exists($file->filepath)) {
            $mimeType = mime_content_type($file->filepath) ?: 'application/octet-stream';
            $filename = $file->filename ?? basename($file->filepath);
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($file->filepath));
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            readfile($file->filepath);
            exit;
        } else {
            http_response_code(404);
            echo "Файл не найден";
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $file = $this->fileRepository->get($id);
            $this->fileRepository->delete($id);
            DB::commit();
            if (file_exists($file->filepath)) {
                unlink($file->filepath);
            }
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            DB::rollBack();
        }
    }
    public function generateUniqueName($filename) : string {
        return time() . '_' . $filename;
    }
}
