<?php

namespace App\Http\Requests\TeacherEval\AnswerQuestion;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'skill.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'type.id' => [
                'required',
                'integer',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'skill.description' => 'descripción',
            'type.id' => 'tipo-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
