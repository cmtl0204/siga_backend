<?php

namespace App\Http\Requests\Uic\Requirement;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequirementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'requirement.name' => [
                'required',
                'string'
            ],
            'requirement.is_required' => [
                'required',
                'bool'
            ],
            'requirement.is_solicitable' => [
                'required',
                'bool'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'requirement.name' => 'nombre',
            'requirement.is_required' => 'es requerido',
            'requirement.is_solicitable' => 'es solicitado'
        ];
        return UicFormRequest::attributes($attributes);
    }
}