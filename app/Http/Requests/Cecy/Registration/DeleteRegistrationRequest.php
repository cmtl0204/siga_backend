<?php

namespace App\Http\Requests\Cecy\Registration;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ids' => [
                'required',
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}