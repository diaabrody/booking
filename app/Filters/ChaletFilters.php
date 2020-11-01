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
                            'checkin_date' =>'filterQueryByCheckinDate',
                            'checkout_date' =>'filterQueryByCheckoutDate',
                            'resort_id' =>'filterQueryByResortId' ,
                            'chalet_type_id' => 'filterQueryByChaletTypeId',
                            'chalet_view_id' =>'filterQueryByChaletViewId',
                            'city_id' =>'filterQueryByCityId',
                            'price_range' =>'filterQueryByPriceRange',
                            'capacity' =>'filterQueryByCapacity' ,
                            'discount'=>'getChaletsHasDiscount'
                        ];

    public function filterQueryByCheckinDate($date){
        if($this->isCheckOutExists($date)){
            $checkout_date= $this->request->input('checkout_date');
            $results = $this->chaletRepository
                ->fetchReservedChaletsIds($date ,$checkout_date)
                ->toArray();
            $this
                ->chaletRepository
                ->fetchNotReservedChaletsByChaletsReservedIdsAndReturnBuilder($this->builder,$results);
        }
        return $this->builder;
    }

    public function filterQueryByCityId($cityId){
        $this->chaletRepository->fetchByCityIdAndReturnBuilder($this->builder , $cityId);
        return $this->builder;
    }

    public function filterQueryByResortId($resortId){
        $this->chaletRepository->fetchByResortIdAndReturnBuilder($this->builder , $resortId);
        return $this->builder;
    }

    public function filterQueryByChaletTypeId($typeId){
        $this->chaletRepository->fetchByChaletTypeAndReturnBuilder($this->builder,$typeId);
        return $this->builder;
    }

    public function filterQueryByChaletViewId($chaletViewId){
        $this->chaletRepository->fetchByChaletViewAndReturnBuilder($this->builder,$chaletViewId);
        return $this->builder;
    }

    public function filterQueryByPriceRange($priceRange){
        $this->chaletRepository->fetchByPriceRangeAndReturnBuilder($this->builder , $this->processPriceRange($priceRange));
        return $this->builder;
    }

    public function filterQueryByCapacity($capacity){
        $this->chaletRepository->fetchByChaletCapacityAndReturnBuilder($this->builder ,$capacity);
        return $this->builder;
    }

    private function processPriceRange($priceRange){
        return explode( '-', $priceRange);
    }

    private function isCheckOutExists($date){
        return (!empty($date)&&$this->request->has('checkout_date') && !empty($this->request->has('checkout_date')));
    }

    public function getChaletsHasDiscount($value){
        $this->chaletRepository->fetchChaletsHasDiscount($this->builder);
        return $this->builder;
    }
}