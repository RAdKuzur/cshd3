<?php

namespace App\Services;

use App\Dictionaries\ThingTypeDictionary;
use App\DTO\NetworkThingDTO;
use App\DTO\TelephoneDTO;
use App\Repositories\NetworkThingRepository;
use Illuminate\Support\Facades\DB;

class NetworkThingService
{
    public NetworkThingRepository $networkThingRepository;

    public function __construct(
        NetworkThingRepository $networkThingRepository
    )
    {
        $this->networkThingRepository = $networkThingRepository;
    }

    public function all() : array
    {
        return $this->networkThingRepository
            ->getWithThings()
            ->map(fn ($networkThing) => new NetworkThingDTO(
                id: $networkThing->id,
                thing_id: $networkThing->thing_id,
                ip_address: $networkThing->ip_address,
                phone_number: $networkThing->phone_number,
                comment: $networkThing->comment,
                inv_number: $networkThing->thing?->inv_number,
                type: $networkThing->thing?->thing_type_id,
                auditorium_id: $networkThing->thing
                    ?->currentAuditorium
                    ?->auditorium
                    ?->id,
            ))
            ->all();
    }

    public function getOne($id) : NetworkThingDTO {
        $networkThing = $this->networkThingRepository->get($id);
        return new NetworkThingDTO(
            id: $networkThing->id,
            thing_id: $networkThing->thing_id,
            ip_address: $networkThing->ip_address,
            phone_number: $networkThing->phone_number,
            comment: $networkThing->comment,
            inv_number: $networkThing->thing->inv_number,
            type: $networkThing->thing->thing_type_id,
            auditorium_id: $networkThing->thing->getCurrentLocation() ? $networkThing->thing->getCurrentLocation()->id : null,
        );
    }

    public function create(NetworkThingDTO $networkThingDTO){

        DB::beginTransaction();
        try {
            if($this->networkThingRepository->isPossibleToCreate($networkThingDTO->thing_id)){
                $this->networkThingRepository->create($networkThingDTO->toArray());
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function update($id, NetworkThingDTO $networkThingDTO){
        DB::beginTransaction();
        try {
            $this->networkThingRepository->update($id, $networkThingDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            $this->networkThingRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function telephonesAll(): array
    {
        return $this->networkThingRepository
            ->getTelephones()
            ->map(fn ($networkThing) => new TelephoneDTO(
                id: $networkThing->id,
                phone_number: $networkThing->phone_number,
                auditorium_id: $networkThing->thing
                    ?->currentAuditorium
                    ?->auditorium
                    ?->id,
                thing_id: $networkThing->thing->id,
            ))
            ->all();
    }
}
