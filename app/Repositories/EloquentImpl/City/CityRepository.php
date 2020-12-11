<?php


namespace App\Repositories\EloquentImpl\City;


use App\City;
use App\Http\Resources\ChaletsCollection;
use App\Http\Resources\CitiesCollection;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\City\ICityRepository;
use Illuminate\Database\Eloquent\Model;

class CityRepository extends BaseRepository implements ICityRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function findTopDestinationsCities($filters, $limit = 5)
    {
        $topDestinationsCities = $this->pagniate($filters, [], $limit, [], ['resorts', 'chalets']);
        return $topDestinationsCities->setCollection($topDestinationsCities->sortByDesc(function ($row) {
            return [$row->chalets_count, $row->resorts_count];
        }));
    }

}