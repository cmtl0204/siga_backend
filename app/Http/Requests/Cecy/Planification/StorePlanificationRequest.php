<?php

namespace App\Http\Requests\Cecy\Planification;

class StorePlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
        
            'id' => [
                'required',
                'integer'
            ],
            'planification.days' => [
                'required',
                'integer',
            ],
            'day_hours' => [
                'required',
                'integer'
            ],
            'proposed_date' => [
                'required',
                'date',
            ],
            'needs' => [
                'required',
                'json'
            ],
            'practice_hours' => [
                'required',
                'integer',
            ],
            'theory_hours' => [
                'required',
                'integer'
            ],
            'approval_date' => [
                'required',
                'date',
            ],
            'project' => [
                'required',
                'string'
            ],
            'installations' => [
                'required',
                'json'
            ]
            
        ]
    }
}


