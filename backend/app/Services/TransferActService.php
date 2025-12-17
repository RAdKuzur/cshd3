<?php

namespace App\Services;

use App\DTO\TransferActDTO;
use App\Repositories\TransferActRepository;
use Illuminate\Support\Facades\DB;

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
    public function get($id)
    {
        $transferAct = $this->transferActRepository->get($id);
        return new TransferActDTO(
            id: $transferAct->id,
            from: $transferAct->from,
            to: $transferAct->to,
            time: $transferAct->time,
            type: $transferAct->type,
            confirmed: $transferAct->confirmed,
            things: $transferAct->transferActThings()->pluck('thing_id')->toArray()
        );
    }
    public function create(TransferActDTO $transferActDTO){
        DB::beginTransaction();
        try {
            $this->transferActRepository->create($transferActDTO->toArray());
            DB::commit();
        }
        catch (\Exception $exception){
            throw $exception;
            DB::rollBack();
        }
    }
}
