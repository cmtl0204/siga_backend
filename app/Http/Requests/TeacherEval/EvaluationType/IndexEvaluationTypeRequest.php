<?php

namespace App\Http\Requests\TeacherEval\EvaluationType;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;

class IndexEvaluationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'parent_id' => [
                'required',
                'integer'
            ],
        ];
        return TeacherEvalFormRequest::rules($rules);
    }


    public function attributes()
    {
        $attributes = [
            'parent_id' => 'id del padre',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
