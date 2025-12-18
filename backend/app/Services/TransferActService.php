<?php

namespace App\Services;

use App\DTO\TransferActDTO;
use App\Repositories\ThingRepository;
use App\Repositories\TransferActRepository;
use App\Repositories\TransferActThingRepository;
use Illuminate\Support\Facades\DB;

class TransferActService
{
    public TransferActRepository $transferActRepository;
    public TransferActThingRepository $transferActThingRepository;
    private ThingRepository $thingRepository;
    public function __construct(
        TransferActRepository $transferActRepository,
        TransferActThingRepository $transferActThingRepository,
        ThingRepository $thingRepository,
    )
    {
        $this->transferActRepository = $transferActRepository;
        $this->transferActThingRepository = $transferActThingRepository;
        $this->thingRepository = $thingRepository;
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
            $transferActDTOId = $this->transferActRepository->create($transferActDTO->toArray());
            foreach ($transferActDTO->things as $thingId) {
                $thing = $this->thingRepository->get($thingId);
                $this->transferActThingRepository->create([
                    'thing_id' => $thing->id,
                    'transferAct_id' => $transferActDTOId
                ]);
            }
            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
        }
    }
}
