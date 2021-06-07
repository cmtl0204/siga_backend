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
            'question.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'evaluation_type.id' => [
                'required',
                'integer',
            ],
            'type.id' => [
                'required',
                'integer',
//                Rule::unique('pgsql-job-board.skills', 'type_id')->ignore($this->id),
            ]
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
