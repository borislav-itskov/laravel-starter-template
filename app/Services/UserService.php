<?php 

namespace App\Services;

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
        return $this->repo->findAdmins();
    }
}