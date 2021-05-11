<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class CheckRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'institution' => [
                'required'
            ],
            'system' => [
                'required',
            ],
            'role' => [
                'required',
            ]
        ];
        return AuthenticationFormRequest::rules($rules );
    }


    public function attributes()
    {
        $attributes = [
            'institution' => 'institución',
            'system' => 'sistema',
            'role' => 'rol',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
