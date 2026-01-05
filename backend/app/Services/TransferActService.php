<?php

namespace App\Services;

use App\Dictionaries\TransferActStatusDictionary;
use App\DTO\TransferActConfirmDTO;
use App\DTO\TransferActDTO;
use App\Models\Thing;
use App\Repositories\PeopleRepository;
use App\Repositories\ThingRepository;
use App\Repositories\TransferActConfirmRepository;
use App\Repositories\TransferActRepository;
use App\Repositories\TransferActThingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferActService
{
    public TransferActRepository $transferActRepository;
    public TransferActThingRepository $transferActThingRepository;
    private ThingRepository $thingRepository;
    private PeopleRepository $peopleRepository;
    private TransferActConfirmRepository $transferActConfirmRepository;
    private UserRepository $userRepository;
    public function __construct(
        TransferActRepository $transferActRepository,
        TransferActThingRepository $transferActThingRepository,
        ThingRepository $thingRepository,
        PeopleRepository $peopleRepository,
        TransferActConfirmRepository $transferActConfirmRepository,
        UserRepository $userRepository
    )
    {
        $this->transferActRepository = $transferActRepository;
        $this->transferActThingRepository = $transferActThingRepository;
        $this->thingRepository = $thingRepository;
        $this->peopleRepository = $peopleRepository;
        $this->transferActConfirmRepository = $transferActConfirmRepository;
        $this->userRepository = $userRepository;
    }

    public function all() : array
    {
        $data = [];
        $transferActs = $this->transferActRepository->getAll();
        foreach ($transferActs as $transferAct) {
            $confirmations = [];
            foreach ($transferAct->transferActConfirms as $transferActConfirm) {
                $confirmations[] = [
                    'username' => $transferActConfirm->peoplePosition->people->user->username,
                    'status' => $transferActConfirm->status,
                ];
            }
            $data[] = new TransferActDTO(
                id: $transferAct->id,
                from: $transferAct->from ? $transferAct->fromPerson->people->id : null,
                to: $transferAct->to ? $transferAct->toPerson->people->id : null,
                date: $transferAct->date,
                type: $transferAct->type,
                confirmed: $transferAct->confirmed,
                things: $transferAct->transferActThings()->pluck('thing_id')->toArray(),
                confirmations: $confirmations
            );
        }
        return $data;
    }
    public function get($id) : TransferActDTO
    {
        $confirmations = [];
        $transferAct = $this->transferActRepository->get($id);
        foreach ($transferAct->transferActConfirms as $transferActConfirm) {
            $confirmations[] = [
                'username' => $transferActConfirm->peoplePosition->people->user->username,
                'status' => $transferActConfirm->status,
            ];
        }
        return new TransferActDTO(
            id: $transferAct->id,
            from: $transferAct->from ? $transferAct->fromPerson->people->id : null,
            to: $transferAct->to ? $transferAct->toPerson->people->id : null,
            date: $transferAct->date,
            type: $transferAct->type,
            confirmed: $transferAct->confirmed,
            things: $transferAct->transferActThings()->pluck('thing_id')->toArray(),
            confirmations: $confirmations
        );
    }
    public function create(TransferActDTO $transferActDTO){
        DB::beginTransaction();
        try {
            if($transferActDTO->from){
                $peopleFrom = $this->peopleRepository->get($transferActDTO->from);
            }
            if($transferActDTO->to){
                $peopleTo = $this->peopleRepository->get($transferActDTO->to);
            }
            $transferActDTOId = $this->transferActRepository->create([
                'from' => isset($peopleFrom) ? $peopleFrom->getActualPeoplePosition()->id : null,
                'to' => isset($peopleTo) ? $peopleTo->getActualPeoplePosition()->id : null,
                'date' => $transferActDTO->date,
                'type' => $transferActDTO->type,
                'confirmed' => TransferActStatusDictionary::NOT_CONFIRMED
            ]);
            if (isset($peopleFrom)){
                $this->transferActConfirmRepository->create([
                    'transfer_act_id' => $transferActDTOId,
                    'people_position_id' => $peopleFrom->getActualPeoplePosition()->id,
                    'status' => TransferActStatusDictionary::NOT_CONFIRMED
                ]);
            }
            if(isset($peopleTo)){
                $this->transferActConfirmRepository->create([
                    'transfer_act_id' => $transferActDTOId,
                    'people_position_id' => $peopleTo->getActualPeoplePosition()->id,
                    'status' => TransferActStatusDictionary::NOT_CONFIRMED
                ]);
            }
            foreach ($transferActDTO->things as $thingId) {
                $thing = $this->thingRepository->get($thingId);
                $this->transferActThingRepository->create([
                    'thing_id' => $thing->id,
                    'transfer_act_id' => $transferActDTOId
                ]);
                $this->thingRepository->update($thing->id, [
                    'is_blocked' => Thing::BLOCKED
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

            foreach ($transferActDTO->things as $thingId) {
                $thing = $this->thingRepository->get($thingId);
                $this->transferActThingRepository->create([
                    'thing_id' => $thing->id,
                    'transfer_act_id' => $id
                ]);
                $this->thingRepository->update($thing->id, [
                    'is_blocked' => Thing::BLOCKED
                ]);
            }

            foreach ($transferActDTO->deletedThings as $deletedThingId) {
                $thing = $this->thingRepository->get($deletedThingId);
                $this->transferActThingRepository->deleteByTransferActIdAndThingId($id, $thing->id);
                $this->thingRepository->update($thing->id, [
                    'is_blocked' => Thing::NOT_BLOCKED
                ]);
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
            $user = $this->userRepository->getByUsername($transferActConfirmDTO->username);
            $person = $this->peopleRepository->get($user->people->id);
            $confirmation = $this->transferActConfirmRepository->getByTransferActIdAndPeoplePositionId(
                $transferAct->id,
                $person->getActualPeoplePosition()->id,
            );
            $this->transferActConfirmRepository->update($confirmation->id, [
                'status' => TransferActStatusDictionary::CONFIRMED
            ]);
            $transferActConfirms = $this->transferActConfirmRepository->getByTransferActId($transferAct->id);
            foreach ($transferActConfirms as $transferActConfirm) {
                if ($transferActConfirm->status != TransferActStatusDictionary::CONFIRMED) {
                    $isConfirmed = false;
                    break;
                }
            }
            if ($isConfirmed) {
                $this->transferActRepository->update($transferAct->id, [
                    'confirmed' => TransferActStatusDictionary::CONFIRMED
                ]);
                foreach($transferAct->transferActThings as $transferActThing) {
                    $this->thingRepository->update($transferActThing->thing->id, [
                        'is_blocked' => Thing::NOT_BLOCKED
                    ]);
                }
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
            $user = $this->userRepository->getByUsername($transferActConfirmDTO->username);
            $person = $this->peopleRepository->get($user->people->id);
            $confirmation = $this->transferActConfirmRepository->getByTransferActIdAndPeoplePositionId(
                $transferActConfirmDTO->transfer_act_id,
                $person->getActualPeoplePosition()->id,
            );
            $this->transferActConfirmRepository->update($confirmation->id, [
                'status' => TransferActStatusDictionary::NOT_CONFIRMED
            ]);
            $transferActConfirms = $this->transferActConfirmRepository->getByTransferActId($transferAct->id);
            foreach ($transferActConfirms as $transferActConfirm) {
                if ($transferActConfirm->status != TransferActStatusDictionary::CONFIRMED) {
                    $isConfirmed = true;
                    break;
                }
            }
            if ($isConfirmed) {
                $this->transferActRepository->update($transferAct->id, [
                    'confirmed' => TransferActStatusDictionary::NOT_CONFIRMED
                ]);
                foreach($transferAct->transferActThings as $transferActThing) {
                    $this->thingRepository->update($transferActThing->thing->id, [
                        'is_blocked' => Thing::BLOCKED
                    ]);
                }
            }
            DB::commit();
        }
        catch (\Exception $exception){
            Log::debug($exception->getMessage());
            DB::rollBack();
        }
    }
}
