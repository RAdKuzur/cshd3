<?php

namespace App\Repositories;

use App\Dictionaries\LicenceDictionary;
use App\Helpers\Auth;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Licence::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('licences')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Licence::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('licences')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Licence::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('licences')->where('id', $id)->delete();
    }
}
