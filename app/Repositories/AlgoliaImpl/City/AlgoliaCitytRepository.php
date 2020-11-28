<?php


namespace App\Repositories\AlgoliaImpl\City;


use App\City;
use App\Repositories\AlgoliaImpl\AlgoliaBaseRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\City\ICityAlgoliaRepository;

class AlgoliaCitytRepository extends AlgoliaBaseRepository implements ICityAlgoliaRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

}