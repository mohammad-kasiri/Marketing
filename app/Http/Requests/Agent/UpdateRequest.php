<?php

namespace App\Http\Requests\Agent;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user_id = $this->route()->parameter('agent');
        return [
            'first_name'      => ['required' , 'min:3', 'max:15', 'bail'] ,
            'last_name'       => ['required' , 'min:3', 'max:25', 'bail'] ,
            'gender'          => ['required' , Rule::in(['male' , 'female']), 'bail'],
            'email'           => ['nullable' , 'email' , 'unique:users,email' , 'bail'],
            'percentage'      => ['nullable' , 'numeric'],
            'avatar'          => ['nullable' , 'image'  , 'max:2048']
        ];
    }
}
