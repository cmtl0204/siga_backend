<?php

namespace App\Http\Requests\Uic\StudentInformation;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentInformationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'studentInformation.student.id' => [
                'required',
                'integer'
            ],
            'studentInformation.company_work' => [
                'required',
                'string'
            ],
            'studentInformation.relation_laboral_career.id' => [
                'required'
            ],
            'studentInformation.company_area.id' => [
                'required'
            ],
            'studentInformation.company_position.id' => [
                'required'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'studentInformation.student.id' => 'estudiante id',
            'studentInformation.company_work' => 'empresa donde labora',
            'studentInformation.relation_laboral_career.id' => 'relacion laboral vs carrera',
            'studentInformation.company_area.id' => 'area',
            'studentInformation.company_position.id' => 'cargo'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
