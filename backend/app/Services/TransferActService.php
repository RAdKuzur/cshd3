<?php

namespace App\Services;

use App\Dictionaries\TransferActStatusDictionary;
use App\DTO\TransferActConfirmDTO;
use App\DTO\TransferActDTO;
use App\Repositories\PeopleRepository;
use App\Repositories\ThingRepository;
use App\Repositories\TransferActConfirmRepository;
use App\Repositories\TransferActRepository;
use App\Repositories\TransferActThingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferActService
{
    public TransferActRepository $transferActRepository;
    public TransferActThingRepository $transferActThingRepository;
    private ThingRepository $thingRepository;
    private PeopleRepository $peopleRepository;
    private TransferActConfirmRepository $transferActConfirmRepository;
    public function __construct(
        TransferActRepository $transferActRepository,
        TransferActThingRepository $transferActThingRepository,
        ThingRepository $thingRepository,
        PeopleRepository $peopleRepository,
        TransferActConfirmRepository $transferActConfirmRepository
    )
    {
        $this->transferActRepository = $transferActRepository;
        $this->transferActThingRepository = $transferActThingRepository;
        $this->thingRepository = $thingRepository;
        $this->peopleRepository = $peopleRepository;
        $this->transferActConfirmRepository = $transferActConfirmRepository;
    }

    public function all() : array
    {
        $data = [];
        $transferActs = $this->transferActRepository->getAll();
        foreach ($transferActs as $transferAct) {
            $data[] = new TransferActDTO(
                id: $transferAct->id,
                from: $transferAct->fromPerson->people_id,
                to: $transferAct->toPerson->people_id,
                date: $transferAct->date,
                type: $transferAct->type,
                confirmed: $transferAct->confirmed,
                things: $transferAct->transferActThings()->pluck('thing_id')->toArray()
            );
        }
        return $data;
    }
    public function get($id) : TransferActDTO
    {
        $transferAct = $this->transferActRepository->get($id);
        return new TransferActDTO(
            id: $transferAct->id,
            from: $transferAct->fromPerson->people_id,
            to: $transferAct->toPerson->people_id,
            date: $transferAct->date,
            type: $transferAct->type,
            confirmed: $transferAct->confirmed,
            things: $transferAct->transferActThings()->pluck('thing_id')->toArray()
        );
    }
    public function create(TransferActDTO $transferActDTO){
        DB::beginTransaction();
        try {
            $peopleFrom = $this->peopleRepository->get($transferActDTO->from);
            $peopleTo = $this->peopleRepository->get($transferActDTO->to);
            $transferActDTOId = $this->transferActRepository->create([
                'from' => $peopleFrom->getPosition()->id,
                'to' => $peopleTo->getPosition()->id,
                'date' => $transferActDTO->date,
                'type' => $transferActDTO->type,
                'confirmed' => TransferActStatusDictionary::NOT_CONFIRMED
            ]);

            $this->transferActConfirmRepository->create([
                'transfer_act_id' => $transferActDTOId,
                'people_position_id' => $peopleFrom->getPosition()->id,
                'status' => TransferActStatusDictionary::NOT_CONFIRMED
            ]);
            $this->transferActConfirmRepository->create([
                'transfer_act_id' => $transferActDTOId,
                'people_position_id' => $peopleTo->getPosition()->id,
                'status' => TransferActStatusDictionary::NOT_CONFIRMED
            ]);

            foreach ($transferActDTO->things as $thingId) {
                $thing = $this->thingRepository->get($thingId);
                $this->transferActThingRepository->create([
                    'thing_id' => $thing->id,
                    'transfer_act_id' => $transferActDTOId
                ]);
            }
            DB::commit();
        }
        catch (\Exception $exception){
            Log::debug($exception->getMessage());
            DB::rollBack();
        }
    }
    public function update($id, TransferActDTO $transferActDTO){
        DB::beginTransaction();
        try {
            $peopleFrom = $this->peopleRepository->get($transferActDTO->from);
            $peopleTo = $this->peopleRepository->get($transferActDTO->to);
            $this->transferActRepository->update($id, [
                'from' => $peopleFrom->getPosition()->id,
                'to' => $peopleTo->getPosition()->id,
                'date' => $transferActDTO->date,
                'type' => $transferActDTO->type,
                //'confirmed' => $transferActDTO->confirmed
            ]);
            foreach ($transferActDTO->things as $thingId) {
                $thing = $this->thingRepository->get($thingId);
                $this->transferActThingRepository->create([
                    'thing_id' => $thing->id,
                    'transfer_act_id' => $id
                ]);
            }
            foreach ($transferActDTO->deletedThings as $deletedThingId) {
                $thing = $this->thingRepository->get($deletedThingId);
                $this->transferActThingRepository->delete($thing->id);
            }
            DB::commit();
        }
        catch (\Exception $exception){
            Log::debug($exception->getMessage());
            DB::rollBack();
        }
    }

    public function confirm(TransferActConfirmDTO $transferActConfirmDTO)
    {
        DB::beginTransaction();
        try {
            $isConfirmed = true;
            $transferAct = $this->transferActRepository->get($transferActConfirmDTO->transfer_act_id);
            $person = $this->peopleRepository->get($transferActConfirmDTO->people_id);
            $confirmation = $this->transferActConfirmRepository->getByTransferActIdAndPeoplePositionId(
                $transferAct->id,
                $person->getPosition()->id,
            );
            $this->transferActConfirmRepository->update($confirmation->id, [
                'status' => TransferActStatusDictionary::CONFIRMED
            ]);
            $transferActConfirms = $this->transferActConfirmRepository->getByTransferActId($transferAct->id);
            foreach ($transferActConfirms as $transferActConfirm) {
                if (!$transferActConfirm->status == TransferActStatusDictionary::CONFIRMED) {
                    $isConfirmed = false;
                    break;
                }
            }
            if ($isConfirmed) {
                $this->transferActRepository->update($transferAct->id, [
                    'confirmed' => TransferActStatusDictionary::CONFIRMED
                ]);
            }
            DB::commit();
        }
        catch (\Exception $exception){
            Log::debug($exception->getMessage());
            DB::rollBack();
        }
    }
    public function cancelConfirm(TransferActConfirmDTO $transferActConfirmDTO){
        DB::beginTransaction();
        try {
            $isConfirmed = false;
            $transferAct = $this->transferActRepository->get($transferActConfirmDTO->transfer_act_id);
            $person = $this->peopleRepository->get($transferActConfirmDTO->people_id);
            $confirmation = $this->transferActConfirmRepository->getByTransferActIdAndPeoplePositionId(
                $transferActConfirmDTO->transfer_act_id,
                $person->getPosition()->id,
            );
            $this->transferActConfirmRepository->update($confirmation->id, [
                'status' => TransferActStatusDictionary::NOT_CONFIRMED
            ]);
            $transferActConfirms = $this->transferActConfirmRepository->getByTransferActId($transferAct->id);
            foreach ($transferActConfirms as $transferActConfirm) {
                if (!$transferActConfirm->status == TransferActStatusDictionary::CONFIRMED) {
                    $isConfirmed = true;
                    break;
                }
            }
            if ($isConfirmed) {
                $this->transferActRepository->update($transferAct->id, [
                    'confirmed' => TransferActStatusDictionary::NOT_CONFIRMED
                ]);
            }
            DB::commit();
        }
        catch (\Exception $exception){
            Log::debug($exception->getMessage());
            DB::rollBack();
        }
    }
}
