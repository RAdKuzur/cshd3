<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PermissionRepository
{
    public function hasAccess($userId, $ruleId){
        return DB::table('permissions')->where([
            'user_id' => $userId,
            'rule_id' => $ruleId
        ])->exists();
    }
}
