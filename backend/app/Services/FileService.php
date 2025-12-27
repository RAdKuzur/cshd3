<?php

namespace App\Services;

use App\DTO\FileDTO;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\DB;

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
    public function upload()
    {
        DB::beginTransaction();
        try {

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
    public function download($id){
        $file = $this->fileRepository->get($id);
        /* download file */

    }
    public function delete($id){
        DB::beginTransaction();
        try {

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

}
