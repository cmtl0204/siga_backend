<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthResetPasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => [
                'required'
            ],
            'password' => [
                'required',
                'min:6',
                'max:50'
            ],
            'password_confirm' => [
                'required',
                'same:password'
            ],
        ];
    }

    public function messages()
    {
        $messages = [
            'token.required' => 'El campo :attribute es obligatorio',
            'password.required' => 'El campo :attribute es obligatorio',
            'password.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'password.max' => 'El campo :attribute debe tener maximo :max caracteres',
            'password_confirm.required' => 'El campo :attribute es obligatorio',
            'password_confirm.same' => 'El campo :attribute no coincide',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'token' => 'token',
            'password' => 'password',
            'password_confirm' => 'password confirm',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
