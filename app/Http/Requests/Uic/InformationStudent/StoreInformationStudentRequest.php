<?php

namespace App\Http\Requests\Uic\InformationStudent;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreInformationStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'informationStudent.student_id' => [
                'required',
                'integer'
            ],
            'informationStudent.province_birth' => [
                'required',
                'string'
            ],
            'informationStudent.canton_birth' => [
                'required',
                'string'
            ],
            'informationStudent.company_work' => [
                'required',
                'string'
            ],
            'informationStudent.relation_laboral_career' => [
                'required',
                'string'
            ],
            'informationStudent.area' => [
                'json',
                'string'
            ],
            'informationStudent.position' => [
                'json',
                'string'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'informationStudent.student_id' => 'estudiante id',
            'informationStudent.province_birth' => 'provincia de nacimiento',
            'informationStudent.canton_birth' => 'canton de nacimiento',
            'informationStudent.company_work' => 'empresa donde labora',
            'informationStudent.relation_laboral_career' => 'relacion laboral vs carrera',
            'informationStudent.area' => 'area',
            'informationStudent.position' => 'cargo'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
