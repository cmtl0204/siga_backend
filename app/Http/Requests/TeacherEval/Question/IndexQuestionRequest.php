<?php

namespace App\Http\Requests\TeacherEval\Question;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;


class IndexQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            /*'question.code' => [
                'required',

                'max:10',
            ],
            'question.order' => [
                '',

                'max:10',
            ],
            'question.name' => [
                'required',

                'max:10',
            ],
            'question.description' => [
                'required',

                'max:10',
            ],
*/
            'evaluation_type_id' => [
                'required',
                'integer',
            ],
           /* 'status.id' => [
                '',
                'integer',
            ],
            'type.id' => [
                '',
                'integer',

            ]*/
        ];
        return TeacherEvalFormRequest::rules($rules);
    }


    public function attributes()
    {
        $attributes = [
            'question.description' => 'descripción',
            'evaluation_type.id' => 'evaluation_type-id',
            'type.id' => 'tipo-id',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
