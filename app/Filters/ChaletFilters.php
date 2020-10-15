<?php


namespace App\Filters;


use App\Exceptions\CustomValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaletFilters extends Filters
{
    protected $filters = ['checkin_date' , 'checkout_date'];

    public function checkin_date($date){
        if($this->isCheckOutExists($date)){
            $subQuery = 'SELECT chalet_id , status FROM chalet_reservations WHERE  NOT( (end_date < :start_date OR start_date > :end_date) AND status =1)';
            $results = collect(DB::select($subQuery , ['end_date'=> $this->request->input('checkout_date'),'start_date'=>$date]))
                        ->pluck('chalet_id')
                        ->toArray();
            return $this->builder->whereNotIn('id',$results);
        }
        return $this->builder;
    }

    private function isCheckOutExists($date){
        return (!empty($date)&&$this->request->has('checkout_date') && !empty($this->request->has('checkout_date')));
    }
}