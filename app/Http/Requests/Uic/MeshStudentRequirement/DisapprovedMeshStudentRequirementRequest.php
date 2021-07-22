<?php

namespace App\Http\Requests\Uic\MeshStudentRequirement;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class DisapprovedMeshStudentRequirementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [

            'meshStudentRequirement.observations' => [
                'required'

            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'meshStudentRequirement.observations' => 'observación'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
