<?php

namespace App\Http\Requests\Uic\MeshStudentRequirement;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class DeleteMeshStudentRequirementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ids' => [],
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return UicFormRequest::attributes($attributes);
    }
}