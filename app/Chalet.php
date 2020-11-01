<?php

namespace App;

use App\Filters\ChaletFilters;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

class Chalet extends Model
{
    public const LIMIT_NUMBER = 20;
    protected  $with =['chaletView' ,'ChaletType', 'city' , 'resort'];



    //

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservationChalet(){
        return $this->hasMany(ChaletReservation::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chaletView(){
       return $this->belongsTo(ChaletView::class , 'chalet_view_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chaletType()
    {
        return $this->belongsTo(ChaletType::class ,'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(){
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resort(){
        return $this->belongsTo(Resort::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function views(){
        return $this->morphMany(UserView::class ,'viewable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function rates(){
        return $this->morphMany(Rating::class , 'ratable');
    }


    public function scopeFilter($query , ChaletFilters $filters){
       return $filters->apply($query);
    }
}
