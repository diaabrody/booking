<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChaletReservation extends Model
{
    //
    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function chalet(){
        return $this->belongsTo(Chalet::class);
    }
}
