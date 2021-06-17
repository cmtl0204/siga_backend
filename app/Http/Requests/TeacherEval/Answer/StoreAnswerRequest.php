<?php

namespace App\Http\Requests\TeacherEval\Answer;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;


class StoreAnswerRequest extends FormRequest
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
                'integer',
            ],
            'answer.order' => [
                'required',
                'integer',
            ],
            'answer.name' => [
                'required',
                'min:6',
                'max:250',
            ],
            'answer.value' => [
                'required',
                'max:250',
            ],
            'status.id' => [
                'required',
            ],
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'answer.code' => 'código',
            'answer.order' => 'orden',
            'answer.name' => 'nombre',
            'answer.value' => 'valor'
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}