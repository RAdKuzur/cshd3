<?php

namespace App\Repositories;

use App\Models\Organization;

class OrganizationRepository
{
    public function getMainOrganization() : Organization {
        return Organization::where(['id' => env('MAIN_ORGANIZATION_ID', 1)])->first();
    }
}
