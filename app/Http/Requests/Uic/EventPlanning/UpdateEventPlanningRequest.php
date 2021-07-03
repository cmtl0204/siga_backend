<?php

namespace App\Http\Requests\Uic\EventPlanning;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventPlanningRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'eventPlanning.planning.id' => [
                'integer',
                'required'
            ],
            'eventPlanning.event.id' => [
                'integer',
                'required'
            ],
            'eventPlanning.start_date' => [
                'date',
                'required',
            ],
            'eventPlanning.end_date' => [
                'date',
                'required',
            ]

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'eventPlanning.planning.id' => 'convocatoria',
            'eventPlanning.event.id' => 'evento',
            'eventPlanning.start_date' => 'fecha inicio',
            'eventPlanning.end_date' => 'fecha fin',
        ];
        return UicFormRequest::attributes($attributes);
    }
}
