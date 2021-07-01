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
            
            ],
            'experience.position' => [
                'required',
              
            ],
            'experience.start_date' => [
                'required',
                'date',
            ],
            'experience.end_date' => [
                'required',
                'date',
            ],
            'experience.activities' => [
                'required',
         
            ],
            'experience.reason_leave' => [
                'required',
            
            ],
            'experience.is_working' => [
                'required',
            
            ]
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
            'experience.reason_leave' => 'razon dejar',
            'experience.is_working' => 'está trabajando',
    ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
