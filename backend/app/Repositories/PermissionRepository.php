<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PermissionRepository
{
    public function hasAccess($role, $ruleId){
        return DB::table('permissions')->where([
            'role' => $role,
            'rule_id' => $ruleId
        ])->exists();
    }
}
