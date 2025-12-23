<?php

namespace App\Services;

use App\Repositories\DepartmentRepository;

class DepartmentService
{
    public DepartmentRepository $departmentRepository;
    public function __construct(
        DepartmentRepository $departmentRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function all(): array {
        $data = [];
        $departments = $this->departmentRepository->getAll();
        foreach($departments as $department){
            $data[] = [
                'id' => $department->id,
                'name' => $department->name,
            ];
        }
        return $data;
    }
}
