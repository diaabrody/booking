<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChaletView extends Model
{
    //

    public function chalets(){
        return $this->hasMany(Chalet::class);
    }
}
