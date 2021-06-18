<?php

namespace App\Http\Requests\Uic\Project;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            //'project.enrollment_id'=>[
            //    'required',
            //    'int'
            //],
            'project.project_plan_id'=>[
                'required',
                'int'
            ],
            'project.title'=>[
                'required',
                'string'
            ],
            'project.description'=>[
                'required',
                'string'
            ],
            'project.observations'=>[
                'required',
                'json'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            //'project.enrollment_id'=>'id proyecto',
            'project.project_plan_id'=>'id plan proyecto',
            'project.title'=>'titulo',
            'project.description'=>'codigo acta',
            'project.observations'=>'observacion'
        ];
        return UicFormRequest::attributes($attributes);
    }
}