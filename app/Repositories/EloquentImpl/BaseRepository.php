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

    }

    /**
     * @param array $filters
     * @param array $orderBy
     * @return Collection
     */
    public function all($filters = [], $orderBy = array()): Collection
    {
        if (count($orderBy) > 0)
            $this->applyOrders($orderBy);
        $this->applyFilters($filters);
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
     * @return mixed
     */
    public function pagniate($filters = [], $orderBy = array(), $limit = null): LengthAwarePaginator
    {
        if (count($orderBy) > 0)
            $this->applyOrders($orderBy);

        $limitNumber = $this::LIMIT_NUMBER;
        if ($limit && is_int($limit))
            $limitNumber = $limit;
        else if ($this->model::LIMIT_NUMBER)
            $limitNumber = $this->model::LIMIT_NUMBER;
        $this->applyFilters($filters);
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
        return $this->getQuery()->orderBy($field, $value);
    }


    protected function resetQuery()
    {
        $this->query = null;
    }


    /**
     * @param array $filters
     * @return void
     */
    private function applyFilters($filters = [])
    {
        foreach ($filters as $field => $value) {
            $this->query = $this->getQuery()->where($field, $value);
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
}