<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthGetPermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => [
                'required',
                'integer'
            ]
        ];
    }

    public function attributes()
    {
        $attributes = [
            'role' => 'role',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
