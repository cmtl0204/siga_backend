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
                'required',
            ],
            'course.hours' => [
                'required',
                'integer',
            ],
            'professional.id' => [
                'required',
                'integer',
            ],
            'type.id' => [
                'required',
                'integer',
            ],
            'institution.id' => [
                'required',
                'integer',
            ],
            'certificationType.id' => [
                'required',
                'integer',
            ],
            'area.id' => [
                'required',
                'integer',
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
            'professional.id' => 'profesional-ID',
            'type.id' => 'tipo-ID',
            'institution.id.id' => 'institución-ID',
            'certificationType.id' => 'tipo certificación-ID',
            'area.id' => 'area-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
