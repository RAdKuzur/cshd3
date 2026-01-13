<?php

namespace App\Repositories;

use App\Dictionaries\LicenceDictionary;
use App\Models\Licence;
use Illuminate\Support\Facades\DB;

class LicenceRepository
{
    public function get($id) : Licence {
        return Licence::find($id);
    }
    public function getAll() {
        return Licence::all();
    }
    public function hasActiveLicence() : bool
    {
        return DB::table('licences')
            ->where([
                ['is_revoked', '=', LicenceDictionary::ACTIVE],
                ['expires_at', '>', now()]
            ])->exists();
    }

    public function create($data)
    {
        return DB::table('licences')->insert($data);
    }
    public function update($id, $data){
        return DB::table('licences')->where('id', $id)->update($data);
    }
    public function delete($id){
        return DB::table('licences')->where('id', $id)->delete();
    }
}
