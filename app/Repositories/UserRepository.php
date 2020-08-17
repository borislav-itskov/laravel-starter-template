<?php 

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository
{
    /**
     * Find the admins.
     *
     * @return Collection
     */
    public function findAdmins(): Collection
    {
        return $this->getBuilder()->whereIsAdmin(1)->get();
    }

    /**
     * Find users by passed role.
     *
     * @param  Role   $role
     * @return Collection
     */
    public function findByRole(Role $role): Collection
    {
        return $this->getBuilder()
            ->select('users.*')
            ->leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.role_id', '=', $role->id)
            ->distinct()
            ->get()
        ;
    }
}