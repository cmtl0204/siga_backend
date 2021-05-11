<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'client_name' => 'client_name',
        ];
    }
}
