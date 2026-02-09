<?php

namespace App\Services;

use App\DTO\ModelDTO;
use App\Repositories\ModelRepository;

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
        $this->modelRepository->create($modelDTO->toArray());
    }
    public function update($id, ModelDTO $modelDTO) {
        $this->modelRepository->update($id, $modelDTO->toArray());
    }
    public function delete($id) {
        $this->modelRepository->delete($id);
    }
}
