<?php

namespace App\Services;

use App\DTO\HistoryResourceDTO;
use App\Repositories\HistoryResourceRepository;
use App\Repositories\ResourceRepository;
use Illuminate\Support\Facades\DB;

class HistoryResourceService
{
    public HistoryResourceRepository $historyResourceRepository;
    public ResourceRepository $resourceRepository;
    public function __construct(
        HistoryResourceRepository $historyResourceRepository,
        ResourceRepository $resourceRepository
    )
    {
        $this->historyResourceRepository = $historyResourceRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function all() {
        $data = [];
        $historyResources = $this->historyResourceRepository->getAll();
        foreach ($historyResources as $historyResource) {
            $data[] = new HistoryResourceDTO(
                id: $historyResource->id,
                resource_id: $historyResource->resource_id,
                amount: $historyResource->amount
            );
        }
        return $data;
    }

    public function getOne($id) {
        $resourceHistory = $this->historyResourceRepository->getById($id);
        return new HistoryResourceDTO(
            id: $resourceHistory->id,
            resource_id: $resourceHistory->resource_id,
            amount: $resourceHistory->amount
        );
    }

    public function create(HistoryResourceDTO $historyResourceDTO) {
        DB::beginTransaction();
        try {
            $resource = $this->resourceRepository->getById($historyResourceDTO->resource_id);
            $this->historyResourceRepository->create($historyResourceDTO->toArray());
            $this->resourceRepository->update($historyResourceDTO->resource_id, [
                'amount' => $resource->amount + $historyResourceDTO->amount
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function update($id, HistoryResourceDTO $historyResourceDTO) {
        DB::beginTransaction();
        try {
            $oldHistoryResource = $this->historyResourceRepository->getById($id);
            $resource = $this->resourceRepository->getById($historyResourceDTO->resource_id);
            $this->historyResourceRepository->update($id, $historyResourceDTO->toArray());
            $this->resourceRepository->update($historyResourceDTO->resource_id, [
                'amount' => $resource->amount - $oldHistoryResource->amount + $historyResourceDTO->amount
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function delete($id) {
        DB::beginTransaction();
        try {
            $resourceHistory = $this->historyResourceRepository->getById($id);
            $resource = $this->resourceRepository->getById($resourceHistory->resource_id);
            $this->resourceRepository->update($resourceHistory->resource_id, [
                'amount' => $resource->amount - $resourceHistory->amount
            ]);
            $this->historyResourceRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
