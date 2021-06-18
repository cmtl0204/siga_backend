<?php

namespace App\Http\Requests\TeacherEval\EvaluationType  ;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEvaluationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'status.id' => [
                'required',
                'integer',
            ],
            'evaluation_type.name' => [
                'required',
                'max:1000',
            ],
            'evaluation_type.code' => [
                'required',
                'max:1000',
            ],
            'evaluation_type.percentage' => [
                'required',
                'max:1000',
            ],
            'evaluation_type.global_percentage' => [
                'required',
                'max:1000',
            ]
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'evaluation_type.name' => 'nombre',
            'evaluation_type.code' => 'evaluation-type-id',
            'evaluation_type.percentage' => 'evaluation-porcentaje',
            'evaluation_type.global_percentage' => 'evaluation-type-global_percentage',
            'status.id' => 'status-id'
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
