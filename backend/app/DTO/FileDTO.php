<?php

namespace App\DTO;

use App\Models\File;

class FileDTO implements DTO
{
    public ?int $id;
    public ?string $table_name;
    public ?int $row_id;
    public ?string $file_id;
    public ?string $filename;
    public function __construct(
        ?int $id = null,
        ?string $table_name = null,
        ?int $row_id = null,
        ?string $file_id = null,
        ?string $filename = null,
    ){
        $this->id = $id;
        $this->table_name = $table_name;
        $this->row_id = $row_id;
        $this->file_id = $file_id;
        $this->filename = $filename;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'],
            $array['table_name'],
            $array['row_id'],
            $array['file_id'],
            $array['filename']
        );
    }
    public static function fromModel(File $model): self{
        return new self(
            $model->id,
            $model->table_name,
            $model->row_id,
            $model->file_id,
            $model->filename,
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'table_name' => $this->table_name,
            'row_id' => $this->row_id,
            'file_id' => $this->file_id,
            'filename' => $this->filename,
        ];
    }
}
