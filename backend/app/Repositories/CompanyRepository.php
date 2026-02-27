<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Company;
use App\Models\Log;
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
        LogHelper::insert(Company::class, $data);
        return DB::table('companies')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(Company::class, $data, ['id' => $id]);
        return DB::table('companies')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(Company::class, ['id' => $id]);
        return DB::table('companies')->where('id', $id)->delete();
    }
}
