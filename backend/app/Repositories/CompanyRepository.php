<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository
{
    public function getAll() {
        return Company::all();
    }
    public function getById($id) : Company {
        return Company::find($id);
    }
    public function create($data) {
        return DB::table('companies')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('companies')->where('id', $id)->update($data);
    }
    public function delete($id) {
        return DB::table('companies')->where('id', $id)->delete();
    }
}
