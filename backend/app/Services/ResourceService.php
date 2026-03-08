<?php

namespace App\Services;

use App\DTO\ResourceDTO;
use App\Helpers\LogHelper;
use App\Repositories\HistoryResourceRepository;
use App\Repositories\ModelResourceRepository;
use App\Repositories\ResourceRepository;
use Illuminate\Support\Facades\DB;

class ResourceService
{
    public ResourceRepository $resourceRepository;
    public ModelResourceRepository $modelResourceRepository;
    public HistoryResourceRepository $historyResourceRepository;
    public function __construct(
        ResourceRepository $resourceRepository,
        ModelResourceRepository $modelResourceRepository,
        HistoryResourceRepository $historyResourceRepository
    )
    {
        $this->resourceRepository = $resourceRepository;
        $this->modelResourceRepository = $modelResourceRepository;
        $this->historyResourceRepository = $historyResourceRepository;
    }
    public function all() : array
    {
        $data = [];
        $resources = $this->resourceRepository->getAll();
        foreach ($resources as $resource) {
            $data[] = new ResourceDTO(
                id: $resource->id,
                name: $resource->name,
                type: $resource->type,
                amount: $resource->amount
            );
        }
        return $data;
    }
    public function getOne($id) : ResourceDTO
    {
        $resource = $this->resourceRepository->getById($id);
        return new ResourceDTO(
            id: $resource->id,
            name: $resource->name,
            type: $resource->type,
            amount: $resource->amount
        );
    }
    public function create(ResourceDTO $resourceDTO){
        DB::beginTransaction();
        try {
            $this->resourceRepository->create($resourceDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function update($id, ResourceDTO $resourceDTO){
        DB::beginTransaction();
        try {
            $this->resourceRepository->update($id, $resourceDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $resource = $this->resourceRepository->getById($id);
            foreach($resource->modelResources as $modelResource){
                $this->modelResourceRepository->delete($modelResource->id);
            }
            foreach($resource->historyResources as $historyResource){
                $this->historyResourceRepository->delete($historyResource->id);
            }
            $this->resourceRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }
}
