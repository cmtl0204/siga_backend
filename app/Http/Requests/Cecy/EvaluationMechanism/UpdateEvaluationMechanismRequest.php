<?php

namespace App\Http\Requests\Cecy\EvaluationMechanism;

class UpdateEvaluationMechanismRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'instrument.evaluationMechanism' => [
                'required',
                'string',
            ],
        
            'technique.evaluationMechanism' => [
                'required',
                'string'
            ],
        
            'type.id' => [
                'required',
                'integer'
            ],
        
            'status.id' => [
                'required',
                'integer'
            ] 
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'evaluationMechanism.technique' => 'technique',
            'evaluationMechanism.instrument' => 'instrument',
            'type.id' => 'tipo-id',
            'status.id' => 'status-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}


