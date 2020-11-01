<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PriceRange implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
       $priceArray =  explode( '-', trim($value));
       if (is_array($priceArray) && count($priceArray) ==2){
           $priceFrom  = $priceArray[0];
           $priceTo  = $priceArray[1];
           if (is_numeric($priceFrom) && is_numeric($priceTo)){
               $priceFrom = (double)$priceFrom;
               $priceTo = (double) $priceTo;
               return (($priceFrom>=1 && $priceTo>=1)&&$priceFrom<=$priceTo);
           }
       }
       return  false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Error in priceRange field , the correct format should be like this "2000-3000" ';
    }
}
