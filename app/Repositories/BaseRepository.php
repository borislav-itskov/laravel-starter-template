<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Construct
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
        return $this->model->all();
    }

    /**
     * Find a model by ID
     *
     * @param  int $id
     * @return Model|null
     */
    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create a single row
     *
     * @param  array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
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
        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * Delete a model and return the deleted ID
     *
     * @param  Model  $model
     * @return int
     */
    public function delete(Model $model): int
    {
        $deletedId = $model->id;
        $model->delete();
        return $deletedId;
    }

    /**
     * Bulk insert a bunch of rows to the database
     *
     * @param array $data
     * @return void
     */
    public function bulkInsert(array $data): void
    {
        // TO DO: think of a clever way to add timestaps
        foreach (array_chunk($data, 5000) as $insertArray) {
            DB::table($this->model->getTable())->insert($insertArray);
        }
    }
}