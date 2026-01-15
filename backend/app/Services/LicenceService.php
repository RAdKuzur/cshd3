<?php

namespace App\Services;

use App\Dictionaries\LicenceDictionary;
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
        }

    }

    public function create($data) {
        DB::beginTransaction();
        try {
            $this->licenceRepository->create($data);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
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
        }
    }
}
