<?php

namespace App\Repositories;

use App\Dictionaries\ThingTypeDictionary;
use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\NetworkThing;
use Illuminate\Support\Facades\DB;

class NetworkThingRepository
{
    public function isPossibleToCreate($thingId) : bool
    {
        return !DB::table('network_things')->where('thing_id', $thingId)->exists();
    }
    public function getAll()
    {
        return NetworkThing::all();
    }
    public function getTelephones() {
        return NetworkThing::query()
            ->whereHas('thing', fn ($q) =>
            $q->where('thing_type_id', ThingTypeDictionary::IP_TELEPHONE)
            )
            ->with([
                'thing:id',
                'thing.currentAuditorium.auditorium:id'
            ])
            ->get();
    }
    public function getWithThings()
    {
        return NetworkThing::query()
            ->with([
                'thing:id,inv_number,thing_type_id',
                'thing.currentAuditorium.auditorium:id'
            ])
            ->get();
    }

    public function get($id) : NetworkThing {
        return NetworkThing::find($id);
    }
    public function create($data) {
        LogHelper::insert(NetworkThing::class, $data);
        return DB::table('network_things')->insertGetId($data);
    }
    public function update($id, $data) {
        LogHelper::update(NetworkThing::class, $data, ['id' => $id]);
        return DB::table('network_things')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(NetworkThing::class, ['id' => $id]);
        return DB::table('network_things')->where('id', $id)->delete();
    }
}
