<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitiesCollection;
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
        if (request()->exists('limit')) {
            return new CitiesCollection($this->respondWithData($this->cityRepository->pagniate($filters)));
        }
        return new CitiesCollection($this->cityRepository->all($filters));
    }
}
