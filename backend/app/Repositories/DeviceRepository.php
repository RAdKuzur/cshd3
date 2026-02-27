<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
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
        LogHelper::insert(Device::class, $data);
        return DB::table('devices')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(Device::class, $data, ['id' => $id]);
        return DB::table('devices')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(Device::class, ['id' => $id]);
        return DB::table('devices')->where('id', $id)->delete();
    }
}
