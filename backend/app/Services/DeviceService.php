<?php

namespace App\Services;

use App\DTO\DeviceDTO;
use App\Repositories\DeviceRepository;
use Illuminate\Support\Facades\DB;

class DeviceService
{
    public DeviceRepository $deviceRepository;
    public function __construct(
        DeviceRepository $deviceRepository
    )
    {
        $this->deviceRepository = $deviceRepository;
    }
    public function all() : array
    {
        $devices = $this->deviceRepository->getAll();
        $data = [];
        foreach ($devices as $device) {
            $data[] = new DeviceDTO(
                id: $device->id,
                model_id: $device->model_id,
                thing_id: $device->thing_id
            );
        }
        return $data;
    }
    public function getOne($id) : DeviceDTO
    {
        $device = $this->deviceRepository->getById($id);
        return new DeviceDTO(
            id: $device->id,
            model_id: $device->model_id,
            thing_id: $device->thing_id
        );
    }

    public function create(DeviceDTO $deviceDTO) {
        DB::beginTransaction();
        try {
            $this->deviceRepository->create($deviceDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }
    public function update($id, DeviceDTO $deviceDTO) {
        DB::beginTransaction();
        try {
            $this->deviceRepository->update($id, $deviceDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }
    public function delete($id) {
        DB::beginTransaction();
        try {
            $this->deviceRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }
}
