<?php

namespace App\Repositories;

use App\Models\Organization;

class OrganizationRepository
{
    public function getMainOrganization(){
        return Organization::first();
    }
}
