<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chalet extends Model
{
    //
    public function rates(){
        return $this->morphMany(Rating::class , "ratable");
    }
    public function reservationChalet(){
       // return $this->
    }
}
