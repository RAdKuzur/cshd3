<?php

namespace App\Services;

use App\DTO\ResourceDTO;
use App\Repositories\ResourceRepository;

class ResourceService
{
    public ResourceRepository $resourceRepository;
    public function __construct(
        ResourceRepository $resourceRepository
    )
    {
        $this->resourceRepository = $resourceRepository;
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
        return $this->resourceRepository->create($resourceDTO->toArray());
    }
    public function update($id, ResourceDTO $resourceDTO){
        return $this->resourceRepository->update($id, $resourceDTO->toArray());
    }
    public function delete($id){
        return $this->resourceRepository->delete($id);
    }
}
