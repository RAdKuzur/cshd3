<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Device;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class DeviceRepository
{
    public function getAll()
    {
        return Device::all();
    }
    public function getById($id) : Device {
        return Device::find($id);
    }
    public function create($data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Device::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('devices')->insert($data);
    }
    public function update($id, $data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Device::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('devices')->where('id', $id)->update($data);
    }
    public function delete($id) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Device::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('devices')->where('id', $id)->delete();
    }
}
