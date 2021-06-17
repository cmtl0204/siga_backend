<?php

namespace App\Http\Requests\Cecy\EvaluationMechanism;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexEvaluationMechanismRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'evaluationMechanism.instrument' => [
                'required',
                'string',
            ],
        
            'evaluationMechanism.technique' => [
                'required',
                'string'
            ],
        
            'evaluationMechanism.type_id' => [
                'required',
                'integer'
            ],
        
            'evaluationMechanism.status_id' => [
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


