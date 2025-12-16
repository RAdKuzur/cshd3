<?php

namespace App\Services;

use App\DTO\TransferActDTO;
use App\Repositories\TransferActRepository;

class TransferActService
{
    public TransferActRepository $transferActRepository;
    public function __construct(
        TransferActRepository $transferActRepository
    )
    {
        $this->transferActRepository = $transferActRepository;
    }

    public function index()
    {
        $data = [];
        $transferActs = $this->transferActRepository->getAll();
        foreach ($transferActs as $transferAct) {
            $data[] = TransferActDTO::fromModel($transferAct);
        }
        return $data;
    }
}
