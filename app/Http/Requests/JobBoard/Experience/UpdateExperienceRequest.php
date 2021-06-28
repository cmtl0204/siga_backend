<?php

namespace App\Http\Requests\JobBoard\Experience;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
    
    'experience.employer' => [
        'required',
        'string',
    ],
    'experience.position' => [
        'required',
        'string',
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
        'min:20',
    ],
    'experience.reason_leave' => [
        'required',
        'min:10',
        'max:250',
    ],
    'experience.is_working' => [
        'required',
        'boolean',
    ],
 
    'experience.area.id' => [
        'required',
        'integer',
    ]
];
return JobBoardFormRequest::rules($rules);

}



public function attributes()
{
    $attributes = [
        
        'experience.employer' => 'nombre del empleador',
        'experience.position' => 'posicion',
        'experience.start_date' => 'fecha inicio',
        'experience.end_date' => 'fercha fin',
        'experience.activities' => 'ocupaciones',
        'experience.reason_leave' => 'razon dejar',
        'experience.is_working' => 'está trabajando',
        'experience.area.id' => 'area-ID',
   
    ];
    return JobBoardFormRequest::attributes($attributes);
}
}

