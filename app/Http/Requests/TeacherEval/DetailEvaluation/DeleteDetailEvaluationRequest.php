<?php

namespace App\Http\Requests\TeacherEval\DetailEvaluation;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class DeleteDetailEvaluationRequest extends FormRequest
{
    public  function rules()
    {


        $rules = [
            'ids' => [
                'required',
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
            'ids' => 'IDs',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
