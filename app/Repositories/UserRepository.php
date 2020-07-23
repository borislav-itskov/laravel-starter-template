<?php 

namespace App\Repositories;

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
        return $this->model->whereIsAdmin(1)->get();
    }
}