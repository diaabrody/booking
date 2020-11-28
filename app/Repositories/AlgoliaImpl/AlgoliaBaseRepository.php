<?php


namespace App\Repositories\AlgoliaImpl;


use App\Repositories\IAlgoliaRepository;
use Illuminate\Database\Eloquent\Model;

class AlgoliaBaseRepository implements IAlgoliaRepository
{
    protected const LIMIT_NUMBER = 5;

    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;

    }

    public function search($query)
    {
       return $this->model->search($query)->take(self::LIMIT_NUMBER)->get()->toArray();
    }
}