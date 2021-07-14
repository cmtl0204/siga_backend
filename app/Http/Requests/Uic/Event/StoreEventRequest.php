<?php

namespace App\Http\Requests\Uic\Event;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'event.planning.id' => [
                'integer',
                'required'
            ],
            'event.name.id' => [
                'integer',
                'required'
            ],
            'event.start_date' => [
                'date',
                'required',
            ],
            'event.end_date' => [
                'date',
                'required',
                'after_or_equal:event.start_date'
            ]

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'event.planning.id' => 'convocatoria',
            'event.name.id' => 'evento',
            'event.start_date' => 'fecha inicio',
            'event.end_date' => 'fecha fin',
        ];
        return UicFormRequest::attributes($attributes);
    }
}
