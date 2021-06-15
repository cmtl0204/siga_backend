<?php

namespace App\Http\Requests\Uic\Enrollment;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'enrollment.modality_id'=>[
                // 'required',
                // 'integer'
            ],
            'enrollment.school_period_id'=>[
                // 'required',
                // 'integer'
            ],
            'enrollment.date'=>[
                'required'
            ],
            'enrollment.code'=>[
                'required'
            ],
            'enrollment.status_id'=>[
                // 'required',
                // 'integer'
            ],
            'enrollment.observations'=>[
                'nullable'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'enrollment.modality_id'=>'modalidad id',
            'enrollment.school_period_id'=>'periodo académico',
            'enrollment.date'=>'fecha',
            'enrollment.code'=>'código',
            'enrollment.status_id'=>'estado id',
            'enrollment.observations'=>'observaciones'
        ];
        return UicFormRequest::attributes($attributes);
    }
}