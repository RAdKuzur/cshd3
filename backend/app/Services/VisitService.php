<?php

namespace App\Services;

use App\Repositories\VisitRepository;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $this->visitRepository->create();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
