<?php

namespace App\Http\Requests\Jobboard\Experience;

use App\Http\Requests\JobBoard\JobBoardFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
                'required',
                'date',
            ],
            'experience.end_date' => [],
            'experience.activities' => [
                'required',
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
            'experience.employer' => 'nombre de empleadora',
            'experience.position' => 'posicion',
            'experience.start_date' => 'fecha inicio',
            'experience.end_date' => 'fercha fin',
            'experience.activities' => 'ocupaciones',
            'experience.reason_leave' => 'razon que se fue',
            'experience.is_working' => 'está trabajando',
            'experience.is_disability' => 'es discapacitado',

        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}