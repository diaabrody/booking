<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //

    public function resorts(){
        return $this->hasMany(Resort::class);
    }


}
