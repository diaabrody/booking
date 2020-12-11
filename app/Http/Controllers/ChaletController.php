<?php

namespace App\Http\Controllers;

use App\Chalet;
use App\Filters\ChaletFilters;
use App\Http\Requests\GetChaletsRequest;
use App\Http\Resources\ChaletResource;
use App\Http\Resources\ChaletsCollection;
use App\Jobs\LogChaletView;
use App\Repositories\Interfaces\AlgoliaInterfaces\City\ICityAlgoliaRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\Resort\IResortAlgoliaRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\UserView\IUserViewRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaletController extends Controller
{
    public $chaletRepository;
    /**
     * @var IResortAlgoliaRepository
     */
    private $resortAlgoliaRepository;
    /**
     * @var ICityAlgoliaRepository
     */
    private $cityAlgoliaRepository;

    /**
     * ChaletController constructor.
     * @param IChaletRepository $chaletRepository
     * @param IResortAlgoliaRepository $resortAlgoliaRepository
     * @param ICityAlgoliaRepository $cityAlgoliaRepository
     */
    public function __construct(
        IChaletRepository $chaletRepository,
        IResortAlgoliaRepository $resortAlgoliaRepository
        , ICityAlgoliaRepository $cityAlgoliaRepository)
    {
        $this->chaletRepository = $chaletRepository;
        $this->resortAlgoliaRepository = $resortAlgoliaRepository;
        $this->cityAlgoliaRepository = $cityAlgoliaRepository;
    }


    /**
     * @param GetChaletsRequest $request
     * @param ChaletFilters $filers
     * @return ChaletsCollection|\Symfony\Component\HttpFoundation\Response
     */
    public function index(GetChaletsRequest $request, ChaletFilters $filers)
    {
        if (!$request->exists('city_id') && !$request->exists('resort_id') &&$request->exists('query')) {
            $this->MatchQuery();
        }
        return new ChaletsCollection($this->getChalets($filers));
    }

    /**
     * @param ChaletFilters $filers
     * @return mixed
     */
    private function getChalets(ChaletFilters $filers)
    {
        return $this->chaletRepository->fetchChaletsByFilters($filers);
    }

    /**
     * @param $id
     * @return ChaletResource
     */
    public function show($id)
    {
        LogChaletView::dispatch($id, request()->ip(), optional(auth()->user())->id)
            ->onConnection('database');
        return new ChaletResource($this->chaletRepository->findById($id));
    }

    protected function MatchQuery(): void
    {
        $query = request('query');
        $cityResult = $this->cityAlgoliaRepository->search($query);
        $resortResult = $this->resortAlgoliaRepository->search($query);
        if (count($resortResult) > 0) {
            request()->request->add(['resort_id' => $resortResult[0]['id']]);
        } elseif (count($cityResult) > 0) {
            request()->request->add(['city_id' => $cityResult[0]['id']]);
        }
    }
}
