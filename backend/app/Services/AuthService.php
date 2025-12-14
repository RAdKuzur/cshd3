<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Repositories\RuleRepository;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private PermissionRepository $permissionRepository;
    private RuleRepository $ruleRepository;
    public function __construct(
        PermissionRepository $permissionRepository,
        RuleRepository $ruleRepository
    )
    {
        $this->permissionRepository = $permissionRepository;
        $this->ruleRepository = $ruleRepository;
    }
    public function hasAccess($userId, $rule)
    {
        $ruleId = $this->ruleRepository->getByPath($rule) ? $this->ruleRepository->getByPath($rule)->id : 0;
        return $this->permissionRepository->hasAccess($userId, $ruleId);
    }
}
