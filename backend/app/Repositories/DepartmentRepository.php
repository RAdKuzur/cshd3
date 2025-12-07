<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    public function get($id)
    {
        return Department::find($id);
    }
    public function getAll(){
        return Department::all();
    }
}
