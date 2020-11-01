<?php


namespace App\Repositories\EloquentImpl\ChaletRating;


use App\Chalet;
use App\Rating;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\ChaletRating\IChaletRatingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChaletRatingRepository extends BaseRepository implements IChaletRatingRepository
{
    public function __construct(Rating $model)
    {
        parent::__construct($model);
    }


    /**
     * @param $data
     * @param $chaletId
     * @param null $userId
     * @return \InvalidArgumentException
     */
    public function rate($data , $chaletId , $userId =null){
        $rateNumber = (isset($data['rateNumber'])&&is_numeric($data['rateNumber']))?$data['rateNumber']:0;
        $review = (isset($data['review']))?$data['review']:null;
        $userId = ($userId)?$userId:optional(auth()->user())->id();
        if($rateNumber>5 ||$rateNumber<1 || !is_int($userId))
            throw  new \InvalidArgumentException();
        $data = ['user_id'=> $userId, 'ratable_type' =>Chalet::class , 'ratable_id'=>$chaletId] ;
        return $this->model->updateOrCreate($data, ['rating'=>$rateNumber ,'review'=>$review]);
    }


    /**
     * @param $chaletId
     * @return float|int|null
     */
    public function getChaletAvgRatingByChaletId($chaletId){
        $avg = $this->model->where('ratable_id' , $chaletId)
            ->where('ratable_type' , Chalet::class)->avg('rating');
        return $avg?floor($avg*10)/10:null;
    }

    public function delete($id): int
    {
       $model= $this->model->where('ratable_id',$id)->where('ratable_type' , Chalet::class)->firstOrFail();
       return  $this->model->destroy($model->id);
    }


    /**
     * @param $chaletId
     * @return mixed
     */
    public function getChaletTotalPercentageForEveryStart($chaletId){
        return collect($this->model->where('ratable_id' , $chaletId)
            ->where('ratable_type' , Chalet::class)
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')->orderBy('rating' , 'asc')->get()->toArray());
    }


}