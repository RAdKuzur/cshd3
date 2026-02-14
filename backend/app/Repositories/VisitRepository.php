<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitRepository
{
    public function create(){
        $data = [
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
            'host'            => request()->getHost(),
            'request_method'  => request()->method(),
            'request_time'    => now(),
            'url'             => request()->fullUrl(),
            'route'           => optional(request()->route())->getName(),
        ];
        return DB::table('visits')->insert($data);
    }
}
