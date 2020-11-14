<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserView extends Model
{
    protected $guarded  = [];
    //
    public function viewable(){
        return $this->morphTo();
    }

    public  function user(){
        return $this->belongsTo(User::class);
    }
}
