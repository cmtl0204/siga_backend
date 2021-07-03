<?php

namespace App\Http\Requests\Uic\Project;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'project.project_plan_id' => [
                'required',
                'integer'
            ],
            'project.enrollment_id' => [
                'required',
                'int'
            ],
            'project.title' => [
                'required',
                'string'
            ],
            'project.description' => [
                'required',
                'string'
            ],
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'project.enrollment_id' => 'inscripción',
            'project.project_plan_id' => 'proyecto',
            'project.title' => 'título',
            'project.description' => 'descripción',
            'project.observations' => 'observación'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
