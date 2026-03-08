<?php

namespace App\Services;

use App\DTO\ModelDTO;
use App\Helpers\LogHelper;
use App\Repositories\DeviceRepository;
use App\Repositories\ModelRepository;
use App\Repositories\ModelResourceRepository;
use Illuminate\Support\Facades\DB;

class ModelService
{
    public ModelRepository $modelRepository;
    public DeviceRepository $deviceRepository;
    public ModelResourceRepository $modelResourceRepository;
    public function __construct(
        ModelRepository $modelRepository,
        DeviceRepository $deviceRepository,
        ModelResourceRepository $modelResourceRepository
    )
    {
        $this->modelRepository = $modelRepository;
        $this->deviceRepository = $deviceRepository;
        $this->modelResourceRepository = $modelResourceRepository;
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
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
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
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function delete($id) {
        DB::beginTransaction();
        try {
            $model = $this->modelRepository->getById($id);
            foreach($model->devices as $device) {
                $this->deviceRepository->delete($device->id);
            }
            foreach($model->modelResources as $modelResource) {
                $this->modelResourceRepository->delete($modelResource->id);
            }
            $this->modelRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }
}
