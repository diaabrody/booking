<?php

namespace App\Http\Controllers;

use App\Chalet;
use App\Filters\ChaletFilters;
use App\Http\Requests\GetChaletsRequest;
use App\Http\Resources\ChaletsCollection;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaletController extends Controller
{
    public $chaletRepository;
    public function __construct(IChaletRepository $chaletRepository)
    {
        $this->chaletRepository = $chaletRepository;
    }

    public function index(GetChaletsRequest $request, ChaletFilters $filers){
        return new ChaletsCollection($this->getChalets($filers));
    }

    private function getChalets(ChaletFilters $filers){
       return $this->chaletRepository->fetchChaletsByFilters($filers);
    }
}
