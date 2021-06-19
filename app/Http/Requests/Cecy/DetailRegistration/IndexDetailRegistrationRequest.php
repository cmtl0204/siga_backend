<?php

namespace App\Http\Requests\Cecy\DetailRegistration;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexDetailRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'registration_id' => [
                'required',
                'integer'
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'registration_id.required' => 'El campo :attribute es obligatorio',
            'registration_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        return CecyFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'registration_id' => 'registration-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
