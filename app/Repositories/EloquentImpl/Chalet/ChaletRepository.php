<?php


namespace App\Repositories\EloquentImpl\Chalet;


use App\Chalet;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ChaletRepository extends BaseRepository implements IChaletRepository
{
    public function __construct(Chalet $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $filers
     * @return mixed
     */
    public function fetchChaletsByFilters($filers):LengthAwarePaginator{
        return $this->model->filter($filers)->paginate($this->model::LIMIT_NUMBER);
    }

    /**
     * @param $checkInDate
     * @param $checkOutDate
     * @return Collection
     */
    public function fetchReservedChaletsIds($checkInDate, $checkOutDate): Collection {
        $subQuery = 'SELECT chalet_id , status FROM chalet_reservations WHERE  NOT( (end_date < :start_date OR start_date > :end_date) AND status =1)';
        return collect(DB::select($subQuery , ['end_date'=> $checkOutDate,'start_date'=>$checkInDate]))->pluck('chalet_id');
    }



    /**
     * @param $builder
     * @param $cityId
     */
    public function fetchByCityIdAndReturnBuilder(&$builder , $cityId){
        $builder->where('city_id' , $cityId);
    }

    /**
     * @param $builder
     * @param $resortId
     */
    public function fetchByResortIdAndReturnBuilder(&$builder , $resortId){
        $builder->where('resort_id' , $resortId);
    }

    /**
     * @param $builder
     * @param $typeId
     */
    public function fetchByChaletTypeAndReturnBuilder(&$builder , $typeId){
        $builder->where('type_id' , $typeId);
    }

    /**
     * @param $builder
     * @param $chaletViewId
     */
    public function fetchByChaletViewAndReturnBuilder(&$builder , $chaletViewId){
        $builder->where('chalet_view_id' , $chaletViewId);
    }

    /**
     * @param $builder
     * @param $priceRangeArr
     */
    public function fetchByPriceRangeAndReturnBuilder(&$builder , $priceRangeArr){
        $builder->whereBetween('price' , [$priceRangeArr[0] , $priceRangeArr[1]]);
    }

    /**
     * @param $builder
     * @param $capacity
     */
    public function fetchByChaletCapacityAndReturnBuilder(&$builder , $capacity){
        $builder->where('capacity' , '>=' , $capacity)
            ->orderBy('capacity' , 'asc');
    }

    public function fetchNotReservedChaletsByChaletsReservedIdsAndReturnBuilder(&$builder ,array  $chaletsReservedIds){
        $builder->where('isActive' , 1)->whereNotIn('id',$chaletsReservedIds);
    }

    /**
     * @param $id
     */
    public function incrementChaletViewsOne($id)
    {
       $this->findById($id)->increment('total_views');
    }

    /**
     * @param $builder
     */
    public function fetchChaletsHasDiscount(&$builder){
        $builder->where('discount' ,'>' , 0)->orderBy('discount' ,'desc');
    }


    public function getRatingInDetails($chalet = null){
        $chalet = $chalet?:$this->model;

    }

}