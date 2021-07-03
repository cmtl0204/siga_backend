<?php

namespace App\Http\Requests\Uic\Planning;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePlanningRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'planning.name' => [
                //'required',
                //'max:50'
            ],
            'planning.number' => [
                //'integer',
                //'required'
            ],
            'planning.start_date' => [
                'date',
                //'required',
            ],
            'planning.end_date' => [
                'date',
                //'required',
            ],
            'planning.description' => [
                //'required',
                'max:100',
            ],

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [ //verificar los nombres
            'planning.name' => 'nombre',
            'planning.number' => 'número',
            'planning.event' => 'evento',
            'planning.start_date' => 'fecha inicio',
            'planning.end_date' => 'fecha fin',
            'planning.description' => 'descripción'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
