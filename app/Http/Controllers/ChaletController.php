<?php

namespace App\Http\Controllers;

use App\Chalet;
use App\Filters\ChaletFilters;
use App\Http\Requests\GetChaletsRequest;
use App\Http\Resources\ChaletResource;
use App\Http\Resources\ChaletsCollection;
use App\Jobs\LogChaletView;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\UserView\IUserViewRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaletController extends Controller
{
    public $chaletRepository;

    /**
     * ChaletController constructor.
     * @param IChaletRepository $chaletRepository
     */
    public function __construct(IChaletRepository $chaletRepository)
    {
        $this->chaletRepository = $chaletRepository;
    }

    /**
     * @param GetChaletsRequest $request
     * @param ChaletFilters $filers
     * @return ChaletsCollection
     */
    public function index(GetChaletsRequest $request, ChaletFilters $filers){
        return new ChaletsCollection($this->getChalets($filers));
    }

    /**
     * @param ChaletFilters $filers
     * @return mixed
     */
    private function getChalets(ChaletFilters $filers){
       return $this->chaletRepository->fetchChaletsByFilters($filers);
    }

    /**
     * @param $id
     * @return ChaletResource
     */
    public function show($id){
        LogChaletView::dispatch($id , request()->ip() , optional(auth()->user())->id)
            ->onConnection('database');
       return  new ChaletResource($this->chaletRepository->findById($id));
    }
}
