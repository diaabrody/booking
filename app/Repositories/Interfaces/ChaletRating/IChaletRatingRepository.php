<?php


namespace App\Repositories\Interfaces\ChaletRating;


use App\Repositories\IRepository;
interface IChaletRatingRepository extends IRepository
{
    public function rate($data , $chaletId , $userId =null);

}