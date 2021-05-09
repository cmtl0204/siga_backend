<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthGenerateTransactionalCodeRequest extends FormRequest
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
            ]
        ];
    }

    public function attributes()
    {
        $attributes = [
            'token' => 'usuario',

        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
