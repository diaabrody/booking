<?php


namespace App\Repositories\AlgoliaImpl\Resort;


use App\City;
use App\Repositories\AlgoliaImpl\AlgoliaBaseRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\City\ICityAlgoliaRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\Resort\IResortAlgoliaRepository;
use App\Resort;

class AlgoliaResorttRepository extends AlgoliaBaseRepository implements IResortAlgoliaRepository
{
    public function __construct(Resort $model)
    {
        parent::__construct($model);
    }

}