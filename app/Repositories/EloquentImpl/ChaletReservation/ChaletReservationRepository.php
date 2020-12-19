<?php


namespace App\Repositories\EloquentImpl\ChaletReservation;


use App\ChaletReservation;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\ChaletReservation\IChaletReservationRepository;
use Illuminate\Database\Eloquent\Model;

class ChaletReservationRepository extends BaseRepository implements IChaletReservationRepository
{
    public function __construct(ChaletReservation $model)
    {
        parent::__construct($model);
    }

    public function findByUserId($userId){
       return $this->with('chalet')->pagniate(['user_id'=>$userId]);
    }

}