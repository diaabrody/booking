<?php


namespace App\Repositories\EloquentImpl;

use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\Types\Boolean;


class BaseRepository implements IRepository
{
    protected $model;
    protected const LIMIT_NUMBER = 20;
    protected $query = null;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model;

    }

    /**
     * @param array $filters
     * @param array $orderBy
     * @param array $with
     * @param array $withCount
     * @return Collection
     */
    public function all($filters = [], $orderBy = array(), $with = [], $withCount = []): Collection
    {
        $this->prepareSelect($filters, $orderBy, $with, $withCount);
        $result = $this->query->get();
        $this->resetQuery();
        return $result;
    }


    /**
     * @param array $orderBy
     */
    public function applyOrders($orderBy = array())
    {
        foreach ($orderBy as $field => $value) {
            $this->query = $this->orderBy($field, $value);
        }
    }


    protected function getQuery()
    {
        return ($this->query) ? $this->query : $this->model;
    }

    /**
     * @param array $filters
     * @param array $orderBy
     * @param null $limit
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function pagniate($filters = [], $orderBy = array(), $limit = null, $with = [], $withCount = []): LengthAwarePaginator
    {
        $this->prepareSelect($filters, $orderBy, $with, $withCount);
        if ($limit && is_int($limit))
            $limitNumber = $limit;
        else if ($this->model::LIMIT_NUMBER)
            $limitNumber = $this->model::LIMIT_NUMBER;

        $result = $this->query->paginate($limitNumber);
        $this->resetQuery();
        return $result;
    }

    /**
     * @param $field
     * @param string $value
     * @return mixed
     */
    protected function orderBy($field, $value = "asc")
    {
        return $this->query->orderBy($field, $value);
    }


    protected function resetQuery()
    {
        $this->query = $this->model;
    }


    /**
     * @param array $filters
     * @return void
     */
    private function applyFilters($filters = [])
    {
        foreach ($filters as $field => $value) {
            $this->query = $this->query->where($field, $value);
        }
    }

    private function with($with = [])
    {

        foreach ($with as $relation) {
            $this->query = $this->query->with($relation);
        }
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function findById($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $array
     * @return Model|null
     */
    public function create(array $array): ?Model
    {
        // TODO: Implement create() method.
        return $this->model->create($array);
    }

    /**
     * @param $id
     * @param array $array
     * @return Model|null
     */
    public function update($id, array $array): ?Model
    {
        $record = $this->model->findOrFail($array);
        return $record->update($record);
    }


    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->model->destroy($id);
    }

    public function set($model)
    {
        $this->model = $model;
    }

    public function get(): Model
    {
        return $this->model;
    }

    private function withCount($withCount = [])
    {
        foreach ($withCount as $relation) {
            $this->query = $this->query->withCount($relation);
        }
    }

    /**
     * @param array $filters
     * @param array $orderBy
     * @param array $with
     * @param array $withCount
     */
    protected function prepareSelect(array $filters, array $orderBy, array $with, array $withCount): void
    {
        if ($filters && count($filters) > 0)
            $this->applyFilters($filters);
        if ($orderBy && count($orderBy) > 0)
            $this->applyOrders($orderBy);
        if ($with && count($with) > 0)
            $this->with($with);
        if ($withCount && count($withCount) > 0)
            $this->withCount($withCount);
    }
}