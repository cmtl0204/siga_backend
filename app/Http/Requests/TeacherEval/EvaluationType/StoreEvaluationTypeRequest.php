<?php

namespace App\Http\Requests\TeacherEval\EvaluationType;

use App\Http\Requests\TeacherEval\TeacherEvalFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'evaluation_type.name' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'evaluation_type.id' => [
                'required',
                'integer',
            ],
            'status.id' => [
                'required',
                'integer',
//                Rule::unique('pgsql-job-board.skills', 'type_id')->ignore($this->id),
            ]
        ];
        return EvaluationTypeFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'evaluation_type.name' => 'name',
            'evaluation_type.id' => 'evaluation_type_id',
            'stauts.id' => 'status-id',
        ];
        return EvaluationTypeFormRequest::attributes($attributes);
    }
}
