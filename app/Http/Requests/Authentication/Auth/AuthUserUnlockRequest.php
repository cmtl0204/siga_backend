<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthUserUnlockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required'],
            'system' => ['required']
        ];
    }

    public function attributes()
    {
        $attributes = [
            'username' => 'usuario',
            'system' => 'sistema',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
