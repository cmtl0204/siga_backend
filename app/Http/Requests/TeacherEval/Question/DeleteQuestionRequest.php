<?php

namespace App\Http\Requests\TeacherEval\Question;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ids' => [
                'required',
            ],
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
