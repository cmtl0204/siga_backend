<?php

namespace App\Http\Requests\TeacherEval\Answer;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class IndexAnswerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

        public function rules()
    {
        $rules = [];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
