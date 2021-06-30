<?php

namespace App\Http\Requests\Jobboard\Course;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'course.name' => [
                'required',
                'min:10',
                'max:250',
            ],
            'course.description' => [
                'required',
                'min:10',
            ],
            'course.start_date' => [
                'required',
            ],
            'course.end_date' => [
                'required'
            ],
            'course.hours' => [
                'required',
               // 'integer',
            ],

            'course.type.id' => [
                'required',
              //  'integer',
            ],
            'course.institution.id' => [
                'required',
              //  'integer',
            ],
            'course.certification_type.id' => [
                'required',
               // 'integer',
            ],
            'course.area.id' => [
                'required',
               // 'integer',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'course.name' => 'nombre',
            'course.description' => 'descripción',
            'course.start_date' => 'fecha inicial',
            'course.end_date' => 'fecha final', 
            'course.hours' => 'horas',
            'course.type.id' => 'tipo-ID',
            'course.institution.id' => 'institución-ID',
            'course.certification_type.id' => 'tipo certificación-ID',
            'course.area.id' => 'area-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
