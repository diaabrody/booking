<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    public function ratable(){
        return $this->morphTo();
    }
}
