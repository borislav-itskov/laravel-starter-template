<?php 

namespace App\Services;

use App\Models\User;
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
        $roleService = app(RoleService::class);
        $adminRole = $roleService->findAdminRole();

        return $this->repo->findAdmins($adminRole);
    }

    /**
     * FOR SHOWING PURPOSES ONLY
     * Find an user by passed property.
     *
     * @param  mixed $property
     * @param  mixed $value
     * @return User|null
     */
    public function findBy($property, $value): ?User
    {
        return $this->repo->findBy($property, $value);
    }

    /**
     * Find an user by email.
     *
     * @param  string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repo->findByEmail($email);
    }
}