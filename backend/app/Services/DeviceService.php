<?php

namespace App\Services;

use App\DTO\DeviceDTO;
use App\Repositories\DeviceRepository;

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
        $this->deviceRepository->create($deviceDTO->toArray());
    }
    public function update($id, DeviceDTO $deviceDTO) {
        $this->deviceRepository->update($id, $deviceDTO->toArray());
    }
    public function delete($id) {
        $this->deviceRepository->delete($id);
    }
}
