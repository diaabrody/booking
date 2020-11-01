<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public const LIMIT_NUMBER = 20;
    //

    protected $guarded=[];
    public function ratable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
