<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthGetRolesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'institution' => [
                'required',
                'integer'
            ]
        ];
    }

    public function attributes()
    {
        $attributes = [
            'institution' => 'institution',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
