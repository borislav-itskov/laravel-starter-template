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
    public function findAdmins(Role $adminRole): Collection
    {
        return $this->selectQuery
            ->select('users.*')
            ->leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.role_id', '=', $adminRole->id)
            ->distinct()
            ->get()
        ;
    }
}