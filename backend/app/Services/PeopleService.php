<?php

namespace App\Services;

use App\DTO\PeopleDTO;
use App\DTO\StaffDTO;
use App\Repositories\BranchRepository;
use App\Repositories\FileRepository;
use App\Repositories\PeoplePositionRepository;
use App\Repositories\PeopleRepository;

class PeopleService
{
    public PeopleRepository $peopleRepository;
    public BranchRepository $branchRepository;
    public PeoplePositionRepository $peoplePositionRepository;
    public FileRepository $fileRepository;
    public function __construct(
        PeopleRepository $peopleRepository,
        BranchRepository $branchRepository,
        PeoplePositionRepository $peoplePositionRepository,
        FileRepository $fileRepository
    )
    {
        $this->peopleRepository = $peopleRepository;
        $this->branchRepository = $branchRepository;
        $this->peoplePositionRepository = $peoplePositionRepository;
        $this->fileRepository = $fileRepository;
    }
    public function staffAll() : array
    {
        $data = [];
        $branches = $this->branchRepository->getAll();
        foreach ($branches as $branch) {
            $staff = [];
            $branchStaff = $this->peoplePositionRepository->getByActiveBranchStaff($branch->id);
            foreach ($branchStaff as $person) {
                $staff[] = new StaffDTO(
                    id: $person->id,
                    fio:$person->people->getFullFio(),
                    position: $person->position->name,
                    auditorium: $person->people->auditorium->name,
                    start_date: $person->start_date,
                    icon_link: $this->fileRepository->getAvatarFile($person->people->user_id)?->file_id
                );
            }
            $data[] = [
                'branch_id' => $branch->id,
                'branch_name' => $branch->name,
                'staff' => $staff,
            ];
        }
        return $data;
    }
    public function all() : array {
        $data = [];
        $people = $this->peopleRepository->getAll();
        foreach ($people as $person) {
            $data[] = PeopleDTO::fromModel($person);
        }
        return $data;
    }
}
