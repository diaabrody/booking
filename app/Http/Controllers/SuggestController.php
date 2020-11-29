<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiResponse\ApiResponse;
use App\Repositories\Interfaces\AlgoliaInterfaces\City\ICityAlgoliaRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\Resort\IResortAlgoliaRepository;
use Illuminate\Http\Request;

class SuggestController extends Controller
{
    use ApiResponse;

    //
    /**
     * @var ICityAlgoliaRepository
     */
    private $cityAlgoliaRepository;
    /**
     * @var IResortAlgoliaRepository
     */
    private $resortAlgoliaRepository;

    public function __construct(ICityAlgoliaRepository $cityAlgoliaRepository, IResortAlgoliaRepository $resortAlgoliaRepository)
    {
        $this->cityAlgoliaRepository = $cityAlgoliaRepository;
        $this->resortAlgoliaRepository = $resortAlgoliaRepository;
    }

    public function index($suggest)
    {
        $cityResult = $this->cityAlgoliaRepository->search($suggest);
        $resortResult = $this->resortAlgoliaRepository->search($suggest);
        $result['city'] = $cityResult;
        $result['resort'] = $resortResult;
        return $this->respondWithData($result);
    }
}
