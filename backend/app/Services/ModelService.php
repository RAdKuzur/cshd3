<?php

namespace App\Services;

use App\DTO\ModelDTO;
use App\Repositories\ModelRepository;
use Illuminate\Support\Facades\DB;

class ModelService
{
    public ModelRepository $modelRepository;
    public function __construct(
        ModelRepository $modelRepository
    )
    {
        $this->modelRepository = $modelRepository;
    }
    public function all() : array
    {
        $data = [];
        $models = $this->modelRepository->getAll();
        foreach ($models as $model) {
            $data[] = new ModelDTO(
                id: $model->id,
                name: $model->name,
                company_id: $model->company_id,
            );
        }
        return $data;
    }
    public function getOne($id) : ModelDTO
    {
        $model = $this->modelRepository->getById($id);
        return new ModelDTO(
            id: $model->id,
            name: $model->name,
            company_id: $model->company_id,
        );
    }
    public function create(ModelDTO $modelDTO) {
        DB::beginTransaction();
        try {
            $this->modelRepository->create($modelDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function update($id, ModelDTO $modelDTO) {
        DB::beginTransaction();
        try {
            $this->modelRepository->update($id, $modelDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function delete($id) {
        DB::beginTransaction();
        try {
            $this->modelRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }
}
