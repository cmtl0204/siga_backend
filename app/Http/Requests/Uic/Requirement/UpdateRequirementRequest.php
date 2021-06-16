<?php

namespace App\Http\Requests\Uic\Enrollment;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'requirement.name'=>[
                'required',
                'string'
            ],
            'requirement.is_required'=>[
                'required',
                'bool'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'requirement.name'=>'nombre requerimiento',
            'requirement.is_required'=>'es requerido'
        ];
        return UicFormRequest::attributes($attributes);
    }
}