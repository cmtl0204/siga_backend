<?php

namespace App\Http\Requests\Uic\Student;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'student.observations' => []

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'student.observations' => 'observaciones'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
