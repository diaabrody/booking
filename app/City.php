<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class City extends Model
{
    use Searchable;

    protected $hidden =['created_at' , 'updated_at'];

    //
    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'city_index';
    }

    public function resorts(){
        return $this->hasMany(Resort::class);
    }


}
