<?php

namespace App\Services;

use App\Dictionaries\ThingTypeDictionary;
use App\DTO\NetworkThingDTO;
use App\DTO\TelephoneDTO;
use App\Helpers\LogHelper;
use App\Repositories\NetworkThingRepository;
use Illuminate\Support\Facades\DB;

class NetworkThingService
{
    public NetworkThingRepository $networkThingRepository;
    public ElasticsearchService $elasticsearchService;

    public function __construct(
        NetworkThingRepository $networkThingRepository,
        ElasticsearchService $elasticsearchService
    )
    {
        $this->networkThingRepository = $networkThingRepository;
        $this->elasticsearchService = $elasticsearchService;
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
                $networkThingId = $this->networkThingRepository->create($networkThingDTO->toArray());
                $this->elasticsearchService->index(
                    ElasticsearchService::NETWORK_THING_INDEX,
                    [
                        'info' => $networkThingDTO->toSearchString(),
                        'id' => $networkThingId,
                        'attributes' => $networkThingDTO->toSearchArray(),
                    ]
                );
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function update($id, NetworkThingDTO $networkThingDTO){
        DB::beginTransaction();
        try {
            $this->networkThingRepository->update($id, $networkThingDTO->toArray());
            $this->elasticsearchService->updateById(
                ElasticsearchService::NETWORK_THING_INDEX,
                $id,
                [
                    'info' => $networkThingDTO->toSearchString(),
                    'id' => $id,
                    'attributes' => $networkThingDTO->toSearchArray(),
                ]
            );
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            $this->networkThingRepository->delete($id);
            $this->elasticsearchService->deleteByBodyId(ElasticsearchService::NETWORK_THING_INDEX, $id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
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
