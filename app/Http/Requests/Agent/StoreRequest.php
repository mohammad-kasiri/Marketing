<?php

namespace App\Http\Requests\Agent;

use App\Models\Province;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'      => ['required' , 'min:3', 'max:15', 'bail'] ,
            'last_name'       => ['required' , 'min:3', 'max:25', 'bail'] ,
            'mobile'          => ['required' , new PhoneNumber() , 'unique:users,mobile' , 'bail'] ,
            'gender'          => ['required' , Rule::in(['male' , 'female']), 'bail'],
            'email'           => ['nullable' , 'email' , 'unique:users,email' , 'bail'],
            'password'        => ['nullable' , 'min:4' , 'max:20' , 'confirmed'],
            'percentage'      => ['nullable' , 'numeric'],
            'sheba_number'    => ['nullable' , 'string' , 'min:24' , 'max:24'],
            'avatar'          => ['nullable' , 'image'  , 'max:2048'],
            'is_active'       => ['required' , 'in:0,1']
        ];
    }
}
