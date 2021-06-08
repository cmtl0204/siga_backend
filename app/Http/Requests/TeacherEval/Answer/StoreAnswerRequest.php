<?php

namespace App\Http\Requests\TeacherEval\Answer;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'answer.order' => [
                'required',
                'min:3',
                'max:250',
            ],
            'answer.name' => [
                'required',
                'min:3',
                'max:250',
            ],
            'answer.value' => [
                'required',
                'min:3',
                'max:250',
            ],
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'answer.code' => 'código',
            'answer.name' => 'nombre',
            'answer.order' => 'orden',
            'answer.value' => 'valor'
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}