<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password_old' => [
                'required'
            ],
            'password' => [
                'required',
                'min:8',
                'max:30'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ]
        ];
        return AuthenticationFormRequest::messages($messages);
    }


    public function attributes()
    {
        $attributes = [
            'password_old' => 'Password Old',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',

        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
