<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\Repositories\BranchRepository;

class BranchService
{
    public BranchRepository $branchRepository;
    public function __construct(
        BranchRepository $branchRepository
    )
    {
        $this->branchRepository = $branchRepository;
    }

    public function all() : array {
        $data = [];
        $branches = $this->branchRepository->getAll();
        foreach ($branches as $branch){
            $data[] = new BranchDTO(
                id: $branch->id,
                name: $branch->name
            );
        }
        return $data;
    }
}
