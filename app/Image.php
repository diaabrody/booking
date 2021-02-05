<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded =[];
    //
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute($value){
        $value  = ($value)?'storage/'.$value:'';
        return asset($value);
    }
}
