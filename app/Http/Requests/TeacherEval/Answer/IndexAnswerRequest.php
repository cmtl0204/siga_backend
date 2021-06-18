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
        $rules = [
            'status_id' => [
                'required',
            ],
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'status_id' => 'Id estado de la respuesta',
                
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
