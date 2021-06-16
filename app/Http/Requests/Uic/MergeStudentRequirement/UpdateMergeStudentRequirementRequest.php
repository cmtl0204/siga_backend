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
            'mergeStudentRequirement.student_id'=>[
                'required',
                'int'
            ],
            'mergeStudentRequirement.requirement_id'=>[
                'required',
                'int'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'mergeStudentRequirement.student_id'=>'estudiante id',
            'mergeStudentRequirement.requirement_id'=>'requerimiento id '
        ];
        return UicFormRequest::attributes($attributes);
    }
}