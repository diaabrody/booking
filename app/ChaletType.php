<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChaletType extends Model
{
    //

    public function chalets(){
        return $this->hasMany(Chalet::class);
    }
}
