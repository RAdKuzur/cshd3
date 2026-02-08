<?php

namespace App\Services;

use App\DTO\TechWorkDTO;
use App\Models\TechWork;
use App\Repositories\TechWorkRepository;

class TechWorkService
{
    private TechWorkRepository $techWorkRepository;
    public function __construct(
        TechWorkRepository $techWorkRepository
    )
    {
        $this->techWorkRepository = $techWorkRepository;
    }

    public function all() : array
    {
        $data = [];
        $techWorks = $this->techWorkRepository->getAll();
        foreach ($techWorks as $techWork) {
            $data[] = new TechWorkDTO(
                id: $techWork->id,
                startTime: $techWork->start_time,
                endTime: $techWork->end_time,
                status: $techWork->status,
            );
        }
        return $data;
    }
    public function create(TechWorkDTO $techWorkDTO) {
        $this->techWorkRepository->create($techWorkDTO->toArray());
    }
    public function cancel($id) {
        $this->techWorkRepository->update($id, [
            'status' => TechWork::INACTIVE
        ]);
    }

    public function isTechWork() : bool
    {
        return $this->techWorkRepository->isTechWork();
    }
}
