<?php

namespace App\Http\Controllers;

use App\Chalet;
use App\Http\Controllers\ApiResponse\ApiResponse;
use App\Http\Requests\CreateRatingRequest;
use App\Http\Resources\ChaletRatingCollection;
use App\Repositories\Interfaces\ChaletRating\IChaletRatingRepository;
use Illuminate\Http\Request;

class ChaletRatesController extends Controller
{
    use ApiResponse;

    private $chaletRatingRepository;

    /**
     * ChaletRatesController constructor.
     * @param IChaletRatingRepository $chaletRatingRepository
     */
    public function __construct(IChaletRatingRepository $chaletRatingRepository)
    {
        // $this->middleware('auth:api')->except(['index']);
        $this->chaletRatingRepository = $chaletRatingRepository;
    }

    /**
     * @param $chaletId
     * @return ChaletRatingCollection|\Symfony\Component\HttpFoundation\Response
     */
    public function index($chaletId)
    {
        if (request()->exists('totalRating')) {
            $ratings = $this->chaletRatingRepository->getChaletTotalPercentageForEveryStart($chaletId);
            return $this->respond($this->formatTotalPercentageRating($ratings));
        }
        $ratingFilters = ['ratable_id' => $chaletId, 'ratable_type' => Chalet::class];
        $filters = request()->all();
        if (isset($filters['rating']) && intval($filters['rating'])) {
            $ratingFilters['rating'] = $filters['rating'];
        }

        $limit = request()->exists('limit') ? request('limit') : null;
        $orders = request()->only('rating', 'created_at', 'updated_at');
        $orders = $this->correctOrdersBy($orders);
        return new ChaletRatingCollection($this->chaletRatingRepository->pagniate($ratingFilters, $orders, $limit));
    }


    /**
     * @param $chaletId
     * @param CreateRatingRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store($chaletId, CreateRatingRequest $request)
    {
        $userId = $request->input('user_id');
        $rateArr = ['rateNumber' => $request->input('rating'),
            'review' => $request->exists('review') ? $request->input('review') : null];
        $ratingObject = $this->chaletRatingRepository->rate($rateArr, $chaletId, $userId);
        return $this->respond($ratingObject);
    }

    /**
     * @param $ratings
     * @return array
     */
    protected function formatTotalPercentageRating($ratings): array
    {
        $totalAvg = $ratings->avg('rating');
        $total = $ratings->count('rating');
        $ratingResult = $ratings->map(function ($row) use ($total) {
            $row['totalInPercent'] = ($row['total'] / $total * 100);
            return $row;
        });
        $array_keys = $ratingResult->pluck('rating')->toArray();
        $array_values = $ratingResult->toArray();
        $result = array_combine($array_keys, $array_values);
        $result['avg'] = $totalAvg;
        return $result;
    }

    private function correctOrdersBy(array $orders = array())
    {
        if (count($orders) > 0) {
            foreach ($orders as $key => $value) {
                if ($value !== "asc" && $value !== "desc")
                    unset($orders[$key]);
            }
        }
        return $orders;
    }
}
