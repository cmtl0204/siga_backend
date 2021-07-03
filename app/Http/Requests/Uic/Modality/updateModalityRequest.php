<?php

namespace App\Http\Requests\Uic\Modality;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateModalityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'modality.parent_id' => [
                'integer',
                'nullable'
            ],
            'modality.name' => [
                'string',
                'required',
                'max:50'
            ],
            'modality.description' => [
                'required',
                'min:10',
                'max:1000'
            ],
            'modality.career_id' => [
                'required',
                'integer'
            ],
            'modality.status_id' => [
                'required',
                'integer'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'modality.parent_id' => 'modalidad padre id',
            'modality.career_id' => 'carrera id',
            'modality.name' => 'nombre',
            'modality.description' => 'descripción',
            'modality.status_id' => 'estado id'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
