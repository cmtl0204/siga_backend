<?php

namespace App\Http\Requests\TeacherEval\Question;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;


class IndexQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'evaluation_type_id' => [
                'required',
                'integer'
            ],
        ];
        return TeacherEvalFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'evaluation_type_id' => 'El campo :attribute es obligatorio',
            'evaluation_type_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        return TeacherEvalFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'evaluation_type_id' => 'evaluation_type-ID',
        ];
        return TeacherEvalFormRequest::attributes($attributes);
    }
}
