<?php

namespace App\Repositories;

use App\Helpers\Auth;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Company::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('companies')->insert($data);
    }
    public function update($id, $data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Company::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('companies')->where('id', $id)->update($data);
    }
    public function delete($id) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Company::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('companies')->where('id', $id)->delete();
    }
}
