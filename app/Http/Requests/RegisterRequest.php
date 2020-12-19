<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' =>'required|min:6|confirmed',
            'firstName'=> 'required|min:2|max:50' ,
            'lastName' => 'required|min:2|max:50' ,
            'type_id'=>'required|exists:user_types,id'
        ];
    }

    public function getAttributes()
    {
        return $this->validated();
    }
}
