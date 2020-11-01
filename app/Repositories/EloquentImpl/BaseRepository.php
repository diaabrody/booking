<?php


namespace App\Repositories\EloquentImpl;

use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\Types\Boolean;


class BaseRepository implements  IRepository
{
    protected  $model;
    protected const LIMIT_NUMBER=20;

    public function __construct(Model $model)
    {
        $this->model = $model;

    }


    /**
     * @param array $filters
     * @return Collection
     */
    public function all($filters = []):Collection
    {
        return $this->applyFilters($filters)->get();
    }

    /**
     * @param array $filters
     * @param null $limit
     * @return mixed
     */
    public function pagniate($filters = [] , $limit = null):LengthAwarePaginator{
         $limitNumber = $this::LIMIT_NUMBER;
         if ($limit && is_int($limit))
             $limitNumber = $limit;
         else if($this->model::LIMIT_NUMBER)
             $limitNumber = $this->model::LIMIT_NUMBER;

        return $this->applyFilters($filters)->paginate($limitNumber);
    }

    /**
     * @param array $filters
     * @return Model
     */
    private function applyFilters($filters = []){
        $query = $this->model;
        foreach ($filters as $field => $value){
            $query = $query->where($field , $value);
        }
        return $query;
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
    public function create(array  $array): ?Model
    {
        // TODO: Implement create() method.
        return $this->model->create($array);
    }

    /**
     * @param $id
     * @param array $array
     * @return Model|null
     */
    public function update($id , array $array): ?Model
    {
         $record= $this->model->findOrFail($array);
         return $record->update($record);
    }


    /**
     * @param $id
     * @return int
     */
    public function delete($id):int
    {
        return $this->model->destroy($id);
    }

    public function set($model)
    {
        $this->model = $model;
    }

    public function get():Model
    {
       return $this->model;
    }
}