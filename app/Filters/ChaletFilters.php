<?php


namespace App\Filters;


use App\Exceptions\CustomValidationException;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaletFilters extends Filters
{
    private $chaletRepository;
    public function __construct(Request $request, IChaletRepository $chaletRepository)
    {
        $this->chaletRepository = $chaletRepository;
        parent::__construct($request);
    }

    protected $filters = [
                            'checkin_date',
                            'checkout_date',
                            'resort_id' ,
                            'chalet_type_id',
                            'chalet_view_id',
                            'city_id',
                            'price_range',
                            'capacity'
                        ];

    public function checkin_date($date){
        if($this->isCheckOutExists($date)){
            $checkout_date= $this->request->input('checkout_date');
            $results = $this->chaletRepository
                ->fetchChaletsIdsByCheckInOutDates($date ,$checkout_date)
                ->toArray();
            return $this->builder->whereNotIn('id',$results);
        }
        return $this->builder;
    }

    public function city_id($cityId){
        $this->chaletRepository->fetchByCityIdAndReturnBuilder($this->builder , $cityId);
        return $this->builder;
    }

    public function resort_id($resortId){
        $this->chaletRepository->fetchByResortIdAndReturnBuilder($this->builder , $resortId);
        return $this->builder;
    }

    public function chalet_type_id($typeId){
        $this->chaletRepository->fetchByChaletTypeAndReturnBuilder($this->builder,$typeId);
        return $this->builder;
    }

    public function chalet_view_id($chaletViewId){
        $this->chaletRepository->fetchByChaletViewAndReturnBuilder($this->builder,$chaletViewId);
        return $this->builder;
    }

    public function price_range($priceRange){
        $this->chaletRepository->fetchByPriceRangeAndReturnBuilder($this->builder , $this->processPriceRange($priceRange));
        return $this->builder;
    }

    public function capacity($capacity){
        $this->chaletRepository->fetchByChaletCapacityAndReturnBuilder($this->builder ,$capacity);
        return $this->builder;
    }

    private function processPriceRange($priceRange){
        return explode( '-', $priceRange);
    }

    private function isCheckOutExists($date){
        return (!empty($date)&&$this->request->has('checkout_date') && !empty($this->request->has('checkout_date')));
    }
}