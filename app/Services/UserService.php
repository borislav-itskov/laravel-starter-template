<?php 

namespace App\Services;

use App\Services\RoleService;
use Illuminate\Support\Collection;

class UserService extends BaseService
{
    /**
     * Find the admins.
     *
     * @return Collection
     */
    public function findAdmins(): Collection
    {
        // $roleService = app(RoleService::class);
        // $adminRole = $roleService->findAdminRole();

        // return $this->repo->findAdmins($adminRole);
        return $this->repo->findAdmins();
    }
}