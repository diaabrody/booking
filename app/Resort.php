<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Resort extends Model
{
    use Searchable;

    protected $with =['city'];

    protected $hidden =['created_at' , 'updated_at'];

    //

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'resort_index';
    }


    public function city(){
       return $this->belongsTo(City::class);
    }
}
