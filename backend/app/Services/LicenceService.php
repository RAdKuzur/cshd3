<?php

namespace App\Services;

use App\Dictionaries\LicenceDictionary;
use App\DTO\LicenceDTO;
use App\Helpers\LogHelper;
use App\Models\Licence;
use App\Repositories\LicenceRepository;
use Illuminate\Support\Facades\DB;

class LicenceService
{
    public LicenceRepository $licenceRepository;
    public function __construct(
        LicenceRepository $licenceRepository
    )
    {
        $this->licenceRepository = $licenceRepository;
    }

    public function check() : bool
    {
        return $this->licenceRepository->hasActiveLicence();
    }

    public function revoke() {
        DB::beginTransaction();
        try {
            $licences = $this->licenceRepository->getAll();
            foreach ($licences as $licence) {
                $this->licenceRepository->update($licence->id, [
                    'is_revoked' => LicenceDictionary::REVOKED
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }

    public function create(LicenceDTO $licenceDTO) {
        DB::beginTransaction();
        try {
            $this->licenceRepository->create([
                'code' => $licenceDTO->licenceKey,
                'expires_at' => now()->addDays(7),
                'is_revoked' => LicenceDictionary::ACTIVE
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function delete($id) {
        DB::beginTransaction();
        try {
            $this->licenceRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
