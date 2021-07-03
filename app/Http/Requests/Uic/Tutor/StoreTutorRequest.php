<?php

namespace App\Http\Requests\Uic\Tutor;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreTutorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'tutor.project_id' => [
                'int',
                'required'
            ],
            'tutor.teacher_id' => [
                'int',
                'required'
            ],
            'tutor.type_id' => [
                'int',
                'required',
            ],
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'tutor.project_id' => 'proyecto',
            'tutor.teacher_id' => 'docente',
            'tutor.type_id' => 'tipo',
        ];
        return UicFormRequest::attributes($attributes);
    }
}
