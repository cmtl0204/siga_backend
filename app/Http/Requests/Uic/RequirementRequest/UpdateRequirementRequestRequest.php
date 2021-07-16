<?php

namespace App\Http\Requests\Uic\RequirementRequest;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequirementRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'requirementRequest.requirement.id' => [
                'required',
                'integer'
            ],
            'requirementRequest.mesh_student.id' => [
                'required',
                'integer'
            ],
            'requirementRequest.date' => [
                'required'
            ],
            'requirementRequest.is_approved' => [
                'required',
                'boolean'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'requirementRequest.requirement.id' => 'requerimiento',
            'requirementRequest.mesh_student.id' => 'malla del estudiante',
            'requirementRequest.date' => 'fecha',
            'requirementRequest.is_approved' => 'esta arpobado'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
