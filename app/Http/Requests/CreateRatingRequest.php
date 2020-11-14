<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRatingRequest extends FormRequest
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
            'rating'=>'required|numeric|min:1|max:5' ,
            'user_id'=>'exists:users,id' ,
            'body'=>'text|min:4|max:1000'
            //
        ];
    }
    public function messages()
    {
        return [
            'user_id.users'=>'Not an existing ID'
        ];
    }
}
