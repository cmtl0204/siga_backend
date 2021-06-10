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
            'evaluation_types_id' => [
                'required',
                'integer'
            ],
        ];
        return IndexEvaluationTypeRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'evaluation_type_id.required' => 'El campo :attribute es obligatorio',
            'evaluation_type_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        return IndexEvaluationTypeRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'evaluation_types_id' => 'evaluation_types_id',
        ];
        return IndexEvaluationTypeRequest::attributes($attributes);
    }
}
