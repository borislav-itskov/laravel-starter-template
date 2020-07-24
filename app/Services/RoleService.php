<?php 

namespace App\Services;

use App\Models\Role;

class RoleService extends BaseService
{
    /**
     * Find the admin role
     *
     * @return Role
     */
    public function findAdminRole(): Role
    {
        return $this->repo->findAdminRole();
    }
}