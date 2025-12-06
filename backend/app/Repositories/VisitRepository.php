<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class VisitRepository
{
    public function create(){
        return DB::table('visits')->insert(
            [
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'host' => $_SERVER['HTTP_HOST'],
                'request_method' => $_SERVER['REQUEST_METHOD'],
                'request_time' => now(),
                'url' => $_SERVER['REQUEST_URI'],
                'route' => request()->route()->getName()
            ]
        );
    }
}
