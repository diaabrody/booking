<?php


namespace App\Repositories\EloquentImpl;

use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Model;
use PhpParser\ErrorHandler\Collecting;
use Ramsey\Collection\Collection;


class BaseRepository implements  IRepository
{
    protected  $model;

    public function __construct(Model $model)
    {
        $this->model = $model;

    }

    public function all():Collection
    {
        return $this->model->all();
    }

    public function findById(): ?Model
    {
        // TODO: Implement findById() method.
    }

    public function create(): Model
    {
        // TODO: Implement create() method.
    }

    public function update(): Model
    {
        // TODO: Implement update() method.
    }

    public function delete():void
    {
        // TODO: Implement delete() method.
    }
}