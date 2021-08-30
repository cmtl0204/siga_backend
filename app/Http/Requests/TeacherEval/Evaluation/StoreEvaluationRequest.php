<?php

namespace App\Http\Requests\TeacherEval\Evaluation;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class StoreEvaluationRequest extends FormRequest
{
    public  function rules()
    {


        $rules = [
            'teacher.id' => [
                'required',
                'integer'
            ],
            'evaluation_type.id' => [
                'required',
                'integer'
            ],
            'shoolPeriod.id' => [
                'required',
                'integer'
            ],
            'status.id' => [
                'required',
                'integer'
            ],
            'evaluation.result' => [
                'required'

            ],
            'evaluation.percentage' => [
                'required'
            ]
        ];

        return TeacherEvalFormRequest::rules($rules);
    }

    /*public function messages()
    {
        $messages = [
            'evaluation_id' => 'El campo :attribute es obligatorio',
        ];
        return IndexDetailEvaluationRequest::messages($messages);
    }*/



   public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
