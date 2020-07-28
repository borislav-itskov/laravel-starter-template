<?php 

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
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
        return $this->getBuilder()
            ->select('users.*')
            ->leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.role_id', '=', $adminRole->id)
            ->distinct()
            ->get()
        ;
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
        return $this->getBuilder()
            ->where($property, '=', $value)
            ->get()
            ->first()
        ;
    }

    /**
     * Find an user by email.
     *
     * @param  string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->getBuilder()
            ->whereEmail($email)
            ->get()
            ->first()
        ;
    }
}