<?php

namespace App\Http\Requests;

use App\Rules\PriceRange;
use Illuminate\Foundation\Http\FormRequest;

class GetChaletsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'checkin_date' =>'date|date_format:Y-m-d|after_or_equal:today' ,
            'checkout_date' =>'date|date_format:Y-m-d|after:checkin_date' ,
            'resort_id'=>'exists:resorts,id' ,
            'chalet_type_id'=>'exists:chalet_types,id' ,
            'chalet_view_id'=>'exists:chalet_views,id' ,
            'price_range'=>['string' , new PriceRange]
        ];
    }
    public function messages()
    {
        return [
            'resort_id.exists' => 'Not an existing ID',
            'chalet_type_id.exists' => 'Not an existing ID',
            'chalet_view_id.exists' => 'Not an existing ID',

        ];
    }
}
