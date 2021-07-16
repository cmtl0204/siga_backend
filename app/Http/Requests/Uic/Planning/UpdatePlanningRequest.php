<?php

namespace App\Http\Requests\Uic\Planning;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanningRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'planning.career.id' => [
                'required'
            ],
            'planning.name' => [
                'required',
                'max:50'
            ],
            'planning.start_date' => [
                'date',
                'required',
            ],
            'planning.end_date' => [
                'date',
                'required',
                'after_or_equal:planning.start_date'
            ]

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'planning.career.id' => 'carrera',
            'planning.name' => 'nombre',
            'planning.event' => 'evento',
            'planning.start_date' => 'fecha inicio',
            'planning.end_date' => 'fecha fin',

        ];
        return UicFormRequest::attributes($attributes);
    }
}
