<?php

namespace App\Repositories;

use App\Dictionaries\LicenceDictionary;
use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Licence;
use App\Models\Log;
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
        LogHelper::insert(Licence::class, $data);
        return DB::table('licences')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(Licence::class, $data, ['id' => $id]);
        return DB::table('licences')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(Licence::class, ['id' => $id]);
        return DB::table('licences')->where('id', $id)->delete();
    }
}
