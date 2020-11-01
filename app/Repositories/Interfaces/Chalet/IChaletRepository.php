<?php


namespace App\Repositories\Interfaces\Chalet;


use App\Repositories\IRepository;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Collection;

interface IChaletRepository extends IRepository
{
    public function fetchChaletsByFilters($filers);
    public function fetchReservedChaletsIds($checkInDate, $checkOutDate): Collection;
    public function incrementChaletViewsOne($id);
}