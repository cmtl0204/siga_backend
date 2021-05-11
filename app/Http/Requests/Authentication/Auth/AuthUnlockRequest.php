<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthUnlockRequest extends FormRequest
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
            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ];
    }

    public function attributes()
    {
        $attributes = [
            'token' => 'token',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmación de contraseña',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
