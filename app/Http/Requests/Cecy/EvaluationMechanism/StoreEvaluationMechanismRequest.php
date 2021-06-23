<?php

namespace App\Http\Requests\Cecy\EvaluationMechanism;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;

class StoreEvaluationMechanismRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
        
            'evaluation_mechanisms.status.id' => [
                'required',
                'integer'
            ],
            'evaluation_mechanisms.type.id' => [
                'required',
                'integer'
            ],
        
            'evaluation_mechanisms.technique' => [
                'required',
                'string'
            ],
            'evaluation_mechanisms.instrument' => [
                'required',
                'string'
            ]
        ];
        return CecyFormRequest::rules($rules);
    }



    public function attributes()
    {
        $attributes = [
            'evaluation_mechanisms.status.id' => 'estado',
            'evaluation_mechanisms.type.id' => 'tipo',
            'evaluation_mechanisms.technique' => 'technique',
            'evaluation_mechanisms.instrument' => 'instrument',
            
        ];
        return CecyFormRequest::attributes($attributes);
    }
}


