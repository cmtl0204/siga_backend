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
    'professional.id' => [
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

public function messages()
{
    $messages = [
        'professional.id.required' => 'El campo :attribute es obligatorio',
        'professional.id.integer' => 'El campo :attribute debe ser numérico',
        'area.id.required' => 'El campo :attribute es obligatorio',
        'area.id.integer' => 'El campo :attribute debe ser numérico',  
        'experience.employer.required' => 'El campo :attribute es obligatorio',
        'experience.employer.string' => 'El campo :attribute debe ser numérico',
        'experience.position.required' => 'El campo :attribute es obligatorio',
        'experience.position.string' => 'El campo :attribute debe ser numérico',
        'experience.start_date.required' => 'El campo :attribute es obligatorio',
        'experience.start_date.date' => 'El campo :attribute debe ser numérico',
        'experience.end_date.required' => 'El campo :attribute es obligatorio',
        'experience.end_date.date' => 'El campo :attribute debe ser numérico',          
        'experience.activities.required' => 'El campo :attribute es obligatorio',
        'experience.activities.min' => 'El campo :attribute debe tener al menos :min caracteres',
        'experience.reason_leave.required' => 'El campo :attribute es obligatorio',
        'experience.reason_leave.min' => 'El campo :attribute debe tener al menos :min caracteres',
        'experience.reason_leave.max' => 'El campo :attribute no debe superar los :max caracteres',
        'experience.is_working.required' => 'El campo :attribute es obligatorio',
        'experience.is_working.boolean' => 'El campo :attribute debe tener al menos :min caracteres',
    
    ];
    return JobBoardFormRequest::messages($messages);
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
        'professional.id' => 'profesional-ID',
        'area.id' => 'area-ID',
   
    ];
    return JobBoardFormRequest::attributes($attributes);
}
}

