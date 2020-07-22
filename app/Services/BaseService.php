<?php 

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseService
{
    /**
     * @var BaseRepository
     */
    protected $repo;

    /**
     * Construct
     *
     * @param BaseRepository $baseRepo
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->repo = $baseRepo;
    }

    /**
     * Find all rows and return them as a Collection
     *
     * @param  array $options - all kinds of options that
     * you wish to pass to the repository
     * @return Collection
     */
    public function findAll(array $options = []): Collection
    {
        return $this->repo->findAll($options);
    }

    /**
     * Find a model by ID
     *
     * @param  int $id
     * @return Model|null
     */
    public function findById(int $id): ?Model
    {
        return $this->repo->findById($id);
    }

    /**
     * Create a single row
     *
     * @param  array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->repo->create($data);
    }

    /**
     * Update a single row
     *
     * @param  Model $model
     * @param  array $data
     * @return Model
     */
    public function update(Model $model, array $data): Model
    {
        return $this->repo->update($model, $data);
    }

    /**
     * Delete a model and return the deleted ID
     *
     * @param  Model  $model
     * @return int
     */
    public function delete(Model $model): int
    {
        return $this->repo->delete($model);
    }

    /**
     * Bulk insert a bunch of rows to the database
     *
     * @param array $data
     * @return void
     */
    public function bulkInsert(array $data): void
    {
        $this->repo->bulkInsert($data);
    }
}