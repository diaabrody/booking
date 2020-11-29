<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitiesCollection;
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
        if (request()->exists('topDestinationsCities')) {
            return $this->respondWithData($this->cityRepository->findTopDestinationsCities($filters));
        }
        if (request()->exists('limit')) {
            return $this->respondWithData($this->cityRepository->pagniate($filters));
        }
        return $this->respondWithData($this->cityRepository->all($filters));
    }
}
