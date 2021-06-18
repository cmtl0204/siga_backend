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

            'meshStudentRequirement.requirement_id'=>[
                'required',
                'int'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'meshStudentRequirement.requirement_id'=>'requerimiento id '
        ];
        return UicFormRequest::attributes($attributes);
    }
}