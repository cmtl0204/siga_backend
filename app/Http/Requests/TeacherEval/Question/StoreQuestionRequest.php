<?php

namespace App\Http\Requests\TeacherEval\Question;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [

            'question.code' => [
                'required',

                'max:1000',
            ],
            'question.order' => [
                'required',

                'max:1000',
            ],
            'question.name' => [
                'required',

                'max:1000',
            ],
            'question.description' => [
                'required',

                'max:1000',
            ],

            'evaluation_type.id' => [
                '',
                'integer',
            ],
            'status.id' => [
                '',
                'integer',
            ],
            'type.id' => [
                '',
                'integer',

            ]
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'question.description' => 'descripción',
            'evaluation_type.id' => 'evaluation_type_id',
            'type.id' => 'tipo-id',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
