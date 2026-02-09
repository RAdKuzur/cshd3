<?php

namespace App\Repositories;

use App\Models\Device;
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
        return DB::table('devices')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('devices')->where('id', $id)->update($data);
    }
    public function delete($id) {
        return DB::table('devices')->where('id', $id)->delete();
    }
}
