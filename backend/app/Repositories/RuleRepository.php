<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class RuleRepository
{
    public function getByPath($path){
        return DB::table('rules')->where('path', $path)->first();
    }
}
