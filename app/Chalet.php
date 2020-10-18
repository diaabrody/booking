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


    public function ChaletView(){
       return $this->belongsTo(ChaletView::class);
    }

    public function ChaletType()
    {
        return $this->belongsTo(ChaletType::class);
    }

    public function city(){
        return $this->hasOneThrough(City::class , Resort::class);
    }

    public function scopeFilter($query , ChaletFilters $filters){
       $query->where('isActive' , 1);
       return $filters->apply($query);
    }
}
