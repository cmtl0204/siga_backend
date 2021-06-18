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
                'string'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            //'project.enrollment_id'=>'id proyecto',
            'project.project_plan_id'=>'tema proyecto',
            'project.title'=>'descripcion',
            'project.description'=>'codigo acta',
            'project.observations'=>'fecha aprovacion'
        ];
        return UicFormRequest::attributes($attributes);
    }
}