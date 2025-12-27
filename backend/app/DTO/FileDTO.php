<?php

namespace App\DTO;

use App\Models\File;

class FileDTO implements DTO
{
    public ?int $id;
    public ?string $table_name;
    public ?string $row_id;
    public ?string $filepath;
    public function __construct(
        ?int $id = null,
        ?string $table_name = null,
        ?string $row_id = null,
        ?string $filepath = null


    ){
        $this->id = $id;
        $this->table_name = $table_name;
        $this->row_id = $row_id;
        $this->filepath = $filepath;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'],
            $array['table_name'],
            $array['row_id'],
            $array['filepath']
        );
    }
    public static function fromModel(File $model): self{
        return new self(
            $model->id,
            $model->table_name,
            $model->row_id,
            $model->filepath,
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'table_name' => $this->table_name,
            'row_id' => $this->row_id,
            'filepath' => $this->filepath,
        ];
    }
}
