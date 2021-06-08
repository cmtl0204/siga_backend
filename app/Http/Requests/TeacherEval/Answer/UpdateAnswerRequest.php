<?php

namespace App\Http\Requests\TeacherEval\Answer;

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
            'answer.code' => [
                'required',
                'min:3',
                'max:20',
            ],
            'answer.name' => [
                'required',
                'min:3',
                'max:250',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'category.code' => 'código',
            'category.name' => 'nombre',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
