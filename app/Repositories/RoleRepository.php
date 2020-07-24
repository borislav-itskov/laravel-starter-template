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
        return $this->model->whereName('Admin')->get()->first();
    }
}
