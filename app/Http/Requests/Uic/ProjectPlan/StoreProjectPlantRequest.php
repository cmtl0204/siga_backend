<?php

namespace App\Http\Requests\Uic\ProjectPlan;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            //'projectPlan.project_id'=>[
                // 'required',
                // 'int'
            //],
            'projectPlan.theme'=>[
                'required',
                'string'
            ],
            'projectPlan.description'=>[
                'required',
                'string'
            ],
            'projectPlan.act_code'=>[
                'required',
                'int'
            ],
            'projectPlan.approval_date'=>[
                'required',
                'date'
            ],
            'projectPlan.is_aprobed'=>[
                'required',
                'bool'
            ],
            'projectPlan.observations'=>[
                'required',
                'string'
            ],
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'projectPlan.project_id'=>'id proyecto',
            'projectPlan.theme'=>'tema proyecto',
            'projectPlan.description'=>'descripcion',
            'projectPlan.act_code'=>'codigo acta',
            'projectPlan.approval_date'=>'fecha aprovacion',
            'projectPlan.is_aprobed'=>'esta aprobado',
            'projectPlan.observations'=>'observaciones'
        ];
        return UicFormRequest::attributes($attributes);
    }
}