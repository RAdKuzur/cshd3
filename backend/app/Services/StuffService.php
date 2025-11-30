<?php

namespace App\Services;

use App\Repositories\BranchRepository;
use App\Repositories\PeoplePositionRepository;

class StuffService
{
    public BranchRepository $branchRepository;
    public PeoplePositionRepository $peoplePositionRepository;
    public function __construct(
        BranchRepository $branchRepository,
        PeoplePositionRepository $peoplePositionRepository
    )
    {
        $this->branchRepository = $branchRepository;
        $this->peoplePositionRepository = $peoplePositionRepository;
    }
    public function stuffAll()
    {
        $data = [];
        $branches = $this->branchRepository->getAll();
        foreach ($branches as $branch) {
            $stuff = [];
            $branchStuff = $this->peoplePositionRepository->getByActiveBranchStuff($branch->id);
            foreach ($branchStuff as $person) {
                $stuff[] = [
                    'id' => $person->id,
                    'fio' => $person->people->getFullFio(),
                    'position' => $person->position->name,
                    'auditorium' => $person->people->auditorium->name,
                    'start_date' => $person->start_date,
                    'icon_link' => $person->people->icon_link,
                ];
            }
            $data[] = [
                'branch_id' => $branch->id,
                'branch_name' => $branch->name,
                'stuff' => $stuff,
            ];
        }
        return $data;
    }
}
