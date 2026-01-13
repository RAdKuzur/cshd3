<?php

namespace App\Services;

use App\Dictionaries\LicenceDictionary;
use App\Models\Licence;
use App\Repositories\LicenceRepository;

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
        $licences = $this->licenceRepository->getAll();
        foreach ($licences as $licence) {
            $this->licenceRepository->update($licence->id, [
                'is_revoked' => LicenceDictionary::REVOKED
            ]);
        }
    }

    public function create($data) {
        $this->licenceRepository->create($data);
    }

    public function delete($id) {
        $this->licenceRepository->delete($id);
    }
}
