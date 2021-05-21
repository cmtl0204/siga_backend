<?php

namespace App\Http\Requests\Cecy\EvaluationMechanism;

class StoreEvaluationMechanismRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'instrument' => [
                'required',
                'string',
            ],
        
            'technique' => [
                'required',
                'string'
            ],
        
            'id' => [
                'required',
                'integer'
            ]
           
            
        ]
    }
}


