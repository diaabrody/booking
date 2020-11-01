<?php


namespace App\Repositories\Interfaces\UserView;


use App\Repositories\IRepository;


interface IUserViewRepository extends IRepository
{
    public function insertChaletView($chaletId , $ip , $userId= null);
    public function doGuestOrUserViewChalet($chaletId ,$ip,$user_id = null);
}