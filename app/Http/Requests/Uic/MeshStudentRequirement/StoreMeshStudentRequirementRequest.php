<?php

namespace App\Http\Requests\Uic\MeshStudentRequirement;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMeshStudentRequirementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [

            'meshStudentRequirement.requirement_id' => [
                'int',
                'required'

            ],
            'meshStudentRequirement.mesh_student_id' => [
                'int',
                'required'

            ],
            'meshStudentRequirement.is_approved' => [
                'boolean',
                'required'

            ],
            'meshStudentRequirement.observations' => [
                'json',
                'required'

            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'meshStudentRequirement.requirement_id' => 'requerimiento id ',
            'meshStudentRequirement.mesh_student_id' => 'malla del estudiante id ',
            'meshStudentRequirement.is_approved' => 'esta aprovado ',
            'meshStudentRequirement.observations' => 'observaciones ',
        ];
        return UicFormRequest::attributes($attributes);
    }
}
