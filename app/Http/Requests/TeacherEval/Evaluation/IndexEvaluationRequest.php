<?php

namespace App\Http\Requests\TeacherEval\Evaluation;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class IndexEvaluationRequest extends FormRequest
{
    public  function rules()
    {


        $rules = [
            'teacher_id',

            'integer'
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
            'teacher_id' => 'teacher-id',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
