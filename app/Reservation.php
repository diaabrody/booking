<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function chaletReservation(){
        return $this->hasOne(ChaletReservation::class);
    }
}
