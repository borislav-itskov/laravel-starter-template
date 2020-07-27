<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    /**
     * Use the model for creating, updating, deleting.
     * Also, when you want to select something out of the
     * ordinary convetions.
     *
     * @var Model
     */
    protected $model;

    /**
     * Use this builder for all your select statements
     * in the system.
     *
     * @var Illuminate\Database\Eloquent\Builder
     */
    protected $selectQuery;

    /**
     * Construct
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->selectQuery = $model->query()
            ->select($model->getTable() . '.*')
        ;
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
        return $this->selectQuery->get();
    }

    /**
     * Find a model by ID
     *
     * @param  int $id
     * @return Model|null
     */
    public function findById(int $id): ?Model
    {
        return $this->selectQuery->find($id);
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
     * @return void
     */
    public function delete(Model $model): void
    {
        $model->delete();
    }

    /**
     * Bulk insert a bunch of rows to the database
     *
     * @param array $data
     * @return void
     */
    public function bulkInsert(array $data): void
    {
        foreach (array_chunk($data, 5000) as $insertArray) {
            DB::table($this->model->getTable())->insert($insertArray);
        }
    }

    /**
     * Delete all the entries in the passed collection
     *
     * @param  Collection $delete
     * @return void
     */
    public function bulkDelete(Collection $delete): void
    {
        DB::table($this->model->getTable())
            ->whereIn('id', $delete->pluck('id'))
            ->delete()
        ;
    }
}