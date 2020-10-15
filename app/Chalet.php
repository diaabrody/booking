<?php

namespace App;

use App\Filters\ChaletFilters;
use Illuminate\Database\Eloquent\Model;

class Chalet extends Model
{
    public const LIMIT_NUMBER = 20;
    //
    public function rates(){
        return $this->morphMany(Rating::class , "ratable");
    }

    public function reservationChalet(){
        return $this->hasMany(ChaletReservation::class);
    }

    public function scopeFilter($query , ChaletFilters $filters){
       return $filters->apply($query);
    }
}
