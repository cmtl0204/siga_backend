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
            'informationStudent.student.id' => [
                'required',
                'integer'
            ],
            'informationStudent.company_work' => [
                'required',
                'string'
            ],
            'informationStudent.relation_laboral_career.id' => [
                'required'
            ],
            'informationStudent.company_area.id' => [
                'required'
            ],
            'informationStudent.company_position.id' => [
                'required'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'informationStudent.student.id' => 'estudiante id',
            'informationStudent.company_work' => 'provincia de nacimiento',
            'informationStudent.relation_laboral_career.id' => 'canton de nacimiento',
            'informationStudent.company_area.id' => 'empresa donde labora',
            'informationStudent.company_position.id' => 'relacion laboral vs carrera'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
