<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    public function get($id) : Department
    {
        return Department::find($id);
    }
    public function getAll(){
        return Department::all();
    }
}
