<?php

namespace App\Services;

use App\DTO\TechWorkDTO;
use App\Models\TechWork;
use App\Repositories\TechWorkRepository;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $this->techWorkRepository->create($techWorkDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }
    public function cancel($id) {
        DB::beginTransaction();
        try {
            $this->techWorkRepository->update($id, [
                'status' => TechWork::INACTIVE
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }

    public function isTechWork() : bool
    {
        return $this->techWorkRepository->isTechWork();
    }
}
