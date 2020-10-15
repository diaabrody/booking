<?php

namespace App\Http\Requests;

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
            'checkin_date' =>'date|date_format:Y-m-d' ,
            'checkout_date' =>'date|date_format:Y-m-d|after:checkin_date'
        ];
    }
}
