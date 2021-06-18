<?php

namespace App\Http\Requests\TeacherEval\DetailEvaluation;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class StoreDetailEvaluationRequest  extends FormRequest
{
    public  function rules()
    {

        $rules = [
           'evaluation.id' => [
                'required',
                'integer'
            ],
            'detail.result' => [
                'required',
                'integer'
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
            'evaluation.id' => 'evaluation_id',
            'detail.result' => 'result'
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
