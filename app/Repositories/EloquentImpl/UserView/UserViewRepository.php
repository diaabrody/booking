<?php


namespace App\Repositories\EloquentImpl\UserView;


use App\Chalet;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\UserView\IUserViewRepository;
use App\UserView;

class UserViewRepository extends BaseRepository implements IUserViewRepository
{
    private $chaletRepository;
    public function __construct(UserView $model , IChaletRepository $chaletRepository)
    {
        $this->chaletRepository = $chaletRepository;
        parent::__construct($model);
    }


    /**
     * @param $chaletId
     * @param $ip
     * @param null $userId
     */
    public function insertChaletView($chaletId , $ip , $userId= null):void{
        $chalet=  $this->chaletRepository ->findById($chaletId);
        $chalet->views()->updateOrCreate([
            'user_id'=>($userId)?:null ,
            'ip'=>$ip
        ]);
    }


    public function doGuestOrUserViewChalet($chaletId ,$ip,$user_id = null ){
          return   $this->model->where('viewable_id' , $chaletId)
                ->where('viewable_type' , Chalet::class)
                ->Where(function ($builder) use ($ip ,$user_id ){
                    $builder
                        ->where('ip' , $ip);
                        if($user_id){
                            $builder->orWhere('user_id' , $user_id);
                        }
                })->exists();
    }
}