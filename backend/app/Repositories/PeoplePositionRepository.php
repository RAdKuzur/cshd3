<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\PeoplePosition;
use Illuminate\Support\Facades\DB;

class PeoplePositionRepository
{
    public function getAll()
    {
        return PeoplePosition::all();
    }
    public function getById($id) : PeoplePosition
    {
        return PeoplePosition::find($id);
    }

    public function getByBranch($branchId){
        return PeoplePosition::where('branch_id', $branchId)->get();
    }
    public function getByActiveBranchStaff($branchId){
        return PeoplePosition::where('branch_id', $branchId)->where('end_date', null)->get();
    }
    public function create($data)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('people_positions')->insertGetId($data);
    }

    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        DB::table('people_positions')->where('id', $id)->update($data);
    }

    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('people_positions')->where('id', $id)->delete();
    }

    public function isPossibleToCreate($peopleId, $startDate) : bool
    {
        return !DB::table('people_positions')
                ->where('people_id', $peopleId)
                ->where('start_date', '>', $startDate)
                ->exists() && DB::table('people_positions')
                ->where('people_id', $peopleId)
                ->where('end_date', null)
                ->exists();
    }

    public function updateOldOnCreate($peopleId, $endDate)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(['end_date' => $endDate]),
            'extra_bindings' => json_encode([
                'people_id' => $peopleId,
                'end_date' => null
            ]),
            'time' => now()
        ]);
        return DB::table('people_positions')
            ->where('people_id', $peopleId)
            ->where('end_date', null)
            ->update(['end_date' => $endDate]);

    }
    public function updateOldOnUpdate($peopleId, $oldDate, $newDate)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(['end_date' => $newDate]),
            'extra_bindings' => json_encode([
                'people_id' => $peopleId,
                'end_date' => $oldDate
            ]),
            'time' => now()
        ]);
        return DB::table('people_positions')
            ->where('people_id', $peopleId)
            ->where('end_date', $oldDate)
            ->update(['end_date' => $newDate]);

    }
    public function updateOldOnDelete($peopleId, $date)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(['end_date' => null]),
            'extra_bindings' => json_encode([
                'people_id' => $peopleId,
                'end_date' => $date
            ]),
            'time' => now()
        ]);
        return DB::table('people_positions')
            ->where('people_id', $peopleId)
            ->where('end_date', $date)
            ->update(['end_date' => null]);

    }

    public function isPossibleToUpdate($id, $peopleId, $startDate) : bool
    {
        return DB::table('people_positions')
                ->where('id', $id)
                ->where('end_date', null)
                ->exists() && !DB::table('people_positions')
                ->whereNot('id', $id)
                ->where('people_id', $peopleId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }
    public function isPossibleToDelete($id) : bool {
        return DB::table('people_positions')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists();
    }
}
