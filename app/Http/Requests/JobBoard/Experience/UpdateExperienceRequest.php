<?php

namespace App\Http\Requests\JobBoard\Experience;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    private $regularExpresionEmail = '/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
            
            ],
           'experience.is_disability' => [
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
            'experience.reason-leave' => 'razon dejar',
            'experience.is_working' => 'está trabajando',
            'experience.is_disability' => 'es discapacitado',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
