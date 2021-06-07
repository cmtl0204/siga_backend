<?php

namespace App\Http\Requests\TeacherEval\Question;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'question.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'type.id' => [
                'required',
                'integer',
            ]
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'question.description' => 'descripción',
            'type.id' => 'tipo-ID',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
