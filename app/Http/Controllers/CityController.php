<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitiesCollection;
use App\Http\Resources\CityResource;
use App\Http\Resources\TopDestionationsCitiesCollection;
use App\Repositories\Interfaces\City\ICityRepository;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public const LIMIT_NUMBER = 20;
    //
    /**
     * @var ICityRepository
     */
    private $cityRepository;

    public function __construct(ICityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $filters = array();
        $limit = (request()->exists('limit')) ?request('limit'): null;
        if (request()->exists('topDestinationsCities')) {
            return new TopDestionationsCitiesCollection($this->cityRepository->findTopDestinationsCities($filters, $limit));
        }
        if($limit)
            return new CitiesCollection($this->cityRepository->pagniate(array() ,array(), $limit));

        return new CitiesCollection($this->cityRepository->all($filters));
    }

    public function show($id){
       return new CityResource(
           $this->cityRepository
                ->with('resorts')
                ->with('chalets')
                ->withCount(['resorts','chalets'])
                ->findById($id));
    }
}
