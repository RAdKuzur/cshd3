<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\ThingAuditorium;
use Illuminate\Support\Facades\DB;

class ThingAuditoriumRepository
{
    public function get($id) : ThingAuditorium
    {
        return ThingAuditorium::find($id);
    }
    public function getAll(){
        return ThingAuditorium::all();
    }
    public function create($data)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->where('id', $id)->delete();
    }

    public function deleteByListId(array $ids) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['ids' => $ids]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->whereIn('thing_id', $ids)->delete();

    }

    public function isPossibleToCreate($thingId, $startDate) : bool
    {
        return !DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('start_date', '>', $startDate)
            ->exists() && DB::table('thing_auditoriums')
                ->where('thing_id', $thingId)
                ->where('end_date', null)
                ->exists();
    }

    public function updateOldOnCreate($thingId, $endDate)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(['end_date' => $endDate]),
            'extra_bindings' => json_encode([
                'thing_id' => $thingId,
                'end_date' => null
            ]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('end_date', null)
            ->update(['end_date' => $endDate]);

    }
    public function updateOldOnUpdate($thingId, $oldDate, $newDate)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(['end_date' => $newDate]),
            'extra_bindings' => json_encode([
                'thing_id' => $thingId,
                'end_date' => $oldDate
            ]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('end_date', $oldDate)
            ->update(['end_date' => $newDate]);

    }
    public function updateOldOnDelete($thingId, $date)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(['end_date' => null]),
            'extra_bindings' => json_encode([
                'thing_id' => $thingId,
                'end_date' => $date
            ]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('end_date', $date)
            ->update(['end_date' => null]);

    }

    public function isPossibleToUpdate($id, $thingId, $startDate) : bool
    {
        return DB::table('thing_auditoriums')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists() && !DB::table('thing_auditoriums')
                ->whereNot('id', $id)
                ->where('thing_id', $thingId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }
    public function isPossibleToDelete($id) : bool {
        return DB::table('thing_auditoriums')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists();
    }
}
