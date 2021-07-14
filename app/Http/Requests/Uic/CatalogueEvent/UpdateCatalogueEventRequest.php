<?php

namespace App\Http\Requests\Uic\CatalogueEvent;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCatalogueEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'event.name' => [
                'string',
                'required',
                'max:50'

            ],
            'event.description' => [
                'string',
                'required',
                'max:50'
            ]

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'event.name' => 'nombre',
            'event.description' => 'descripcion'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
