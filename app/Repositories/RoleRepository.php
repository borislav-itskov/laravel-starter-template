<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    /**
     * Find the admin role
     *
     * @return Role
     */
    public function findAdminRole(): Role
    {
        return $this->getBuilder()->whereName('Admin')->get()->first();
    }
}
