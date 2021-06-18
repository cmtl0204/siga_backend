<?php

namespace App\Http\Requests\TeacherEval\DetailEvaluation;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class IndexDetailEvaluationRequest extends FormRequest
{
    public  function rules()
    {


        $rules = [
           'evaluation_id' => [
                'required',
                'integer'
            ],



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
            'evaluation_id' => 'evaluation-ID',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
