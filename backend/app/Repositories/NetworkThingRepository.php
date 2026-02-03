<?php

namespace App\Repositories;

use App\Dictionaries\ThingTypeDictionary;
use App\Helpers\Auth;
use App\Models\Log;
use App\Models\NetworkThing;
use Illuminate\Support\Facades\DB;

class NetworkThingRepository
{

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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => NetworkThing::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);

        return DB::table('network_things')->insert($data);
    }
    public function update($id, $data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => NetworkThing::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('network_things')->where('id', $id)->update($data);
    }
    public function delete($id) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => NetworkThing::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('network_things')->where('id', $id)->delete();
    }
}
