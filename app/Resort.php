<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    //

    public function city(){
        $this->belongsTo(City::class);
    }
}
