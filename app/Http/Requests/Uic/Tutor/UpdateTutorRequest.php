<?php

namespace App\Http\Requests\Uic\Tutor;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTutorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'tutor.project_plan.id' => [],
            'tutor.teacher.id' => [
                'int',
                'required'
            ],
            'tutor.type.id' => [
                'int',
                'required',
            ],
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'tutor.project_plan.id' => 'proyecto',
            'tutor.teacher.id' => 'docente',
            'tutor.type.id' => 'tipo',
        ];
        return UicFormRequest::attributes($attributes);
    }
}
