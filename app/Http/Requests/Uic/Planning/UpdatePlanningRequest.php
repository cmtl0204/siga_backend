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
            'planning.name'=>[
                //'max:50',
                //'required'
            ],
            'planning.number'=>[
                //'integer',
                //'required'
            ],
            'planning.start_date'=>[
                'date',
                //'required'
            ],
            'planning.end_date'=>[
                'date',

            ],
            'planning.description'=>[
                'max:100'
            ],

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'planning.name'=>'nombre',
            'planning.number'=>'numero',
            'planning.event'=>'evento',
            'planning.start_date'=>'fecha inicio',
            'planning.end_date'=>'fecha fin',
            'planning.description'=>'descripcion'
        ];
        return UicFormRequest::attributes($attributes);
    }
}

