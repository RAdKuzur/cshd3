<?php

namespace App\Services;

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

    public function index(){
        $data = [];
        $branches = $this->branchRepository->getAll();
        foreach ($branches as $branch){
            $data[] = [
                'id' => $branch->id,
                'name' => $branch->name,
            ];
        }
        return $data;
    }
}
