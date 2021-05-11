<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => [
                'required'
            ],
            'password' => [
                'required'
            ],
            'client_id' => [
                'required'
            ],
            'client_secret' => [
                'required'
            ],
            'grant_type' => [
                'required'
            ],

        ];
    }

    public function attributes()
    {
        $attributes = [
            'username' => 'usuario',
            'password' => 'contraseña',
            'client_id' => 'cliente-ID',
            'client_secret' => 'cliente-clave-secret',
            'grant_type' => 'cliente-tipo',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
