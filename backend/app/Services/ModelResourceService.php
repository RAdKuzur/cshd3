<?php

namespace App\Services;

use App\DTO\ModelResourceDTO;
use App\Helpers\LogHelper;
use App\Repositories\ModelResourceRepository;
use Illuminate\Support\Facades\DB;

class ModelResourceService
{
    public ModelResourceRepository $modelResourceRepository;
    public function __construct(
        ModelResourceRepository $modelResourceRepository
    )
    {
        $this->modelResourceRepository = $modelResourceRepository;
    }

    public function all() : array
    {
        $data = [];
        $modelResources = $this->modelResourceRepository->getAll();
        foreach ($modelResources as $modelResource) {
            $data[] = new ModelResourceDTO(
                id: $modelResource->id,
                model_id: $modelResource->model_id,
                resource_id: $modelResource->resource_id
            );
        }
        return $data;

    }
    public function getOne($id) : ModelResourceDTO
    {
        $modelResource = $this->modelResourceRepository->getById($id);
        return new ModelResourceDTO(
            id: $modelResource->id,
            model_id: $modelResource->model_id,
            resource_id: $modelResource->resource_id
        );
    }

    public function create(ModelResourceDTO $modelResourceDTO) {
        DB::beginTransaction();
        try {
            $this->modelResourceRepository->create($modelResourceDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function update($id, ModelResourceDTO $modelResourceDTO) {
        DB::beginTransaction();
        try {
            $this->modelResourceRepository->update($id, $modelResourceDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function delete($id) {
        DB::beginTransaction();
        try {
            $this->modelResourceRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
