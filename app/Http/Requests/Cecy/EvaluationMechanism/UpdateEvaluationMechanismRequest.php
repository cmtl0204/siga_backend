<?php

namespace App\Http\Requests\Cecy\EvaluationMechanism;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateEvaluationMechanismRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'evaluation_mechanisms.instrument' => [
                'required',
                'string'
            ],
        
            'evaluation_mechanisms.technique' => [
                'required',
                'string'
            ],
        
            'evaluation_mechanisms.type.id' => [
                'required',
                'integer'
            ],
        
            'evaluation_mechanisms.status.id' => [
                'required',
                'integer'
            ] 
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'evaluation_mechanisms.technique' => 'technique',
            'evaluation_mechanisms.instrument' => 'instrument',
            'type.id' => 'tipo_id',
            'status.id' => 'state_id'
        ];
        return CecyFormRequest::attributes($attributes);
    }
}


