<?php

namespace App\Http\Requests\JobBoard\Experience;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'experience.area.id' => [
                'required',
            ],
            'experience.employer' => [
                'required',
                'min:4',
                'max:250',
            ],
            'experience.position' => [
                'required',
                'min:3',
                'max:250',
            ],
            'experience.start_date' => [
             
                'date',
            ],
            'experience.end_date' => [
                'date',
            ],
            'experience.activities' => [
            
                'array',
            ],
            'experience.reason_leave' => [],
            'experience.is_working' => [
                'boolean',
            ],
            'experience.is_disability' => []
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'experience.area.id' => 'area-ID',
            'experience.employer' => 'nombre de empleador',
            'experience.position' => 'cargo',
            'experience.start_date' => 'fecha inicio',
            'experience.end_date' => 'fercha fin',
            'experience.activities' => 'ocupaciones',
            'experience.reason_leave' => 'razon salida',
            'experience.is_working' => 'está trabajando',
            'experience.is_disability' => 'Es Discapacitado'
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}