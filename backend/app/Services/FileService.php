<?php

namespace App\Services;

use App\DTO\FileDTO;
use App\Helpers\LogHelper;
use App\Models\File;
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
            $data[] = (FileDTO::fromModel($file))->toArray();
        }
        return $data;
    }
    public function get($id) : array
    {
        $file = $this->fileRepository->get($id);
        return (new FileDTO(
            id: $file->id,
            table_name: $file->table_name,
            row_id: $file->row_id,
            file_id: $file->file_id,
            filename: $file->filename,
        ))->toArray();
    }
    public function create(FileDTO $fileDTO)
    {
        if($this->fileRepository->isPossibleToUpload($fileDTO->table_name)) {
            DB::beginTransaction();
            try {
                $this->fileRepository->create([
                    'table_name' => $fileDTO->table_name,
                    'row_id' => $fileDTO->row_id,
                    'file_id' => $fileDTO->file_id,
                    'filename' => $fileDTO->filename
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                LogHelper::error($e->getMessage(), $e->getTraceAsString());
            }
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $this->fileRepository->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function getFiles($tableName, $rowId) : array {
        $data = [];
        $files = $this->fileRepository->getFiles($tableName, $rowId);
        foreach ($files as $file){
            $data[] = FileDTO::fromModel($file);
        }
        return $data;
    }
    public function getAvatarLink($id)
    {
        return $this->fileRepository->getAvatarFile($id)?->file_id;
    }
}
