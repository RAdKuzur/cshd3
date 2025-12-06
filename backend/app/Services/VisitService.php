<?php

namespace App\Services;

use App\Repositories\VisitRepository;

class VisitService
{
    private VisitRepository $visitRepository;
    public function __construct(
        VisitRepository $visitRepository
    )
    {
        $this->visitRepository = $visitRepository;
    }

    public function create(){
        $this->visitRepository->create();
    }
}
