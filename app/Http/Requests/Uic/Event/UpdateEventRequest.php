<?php

namespace App\Http\Requests\Uic\Event;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'event.name'=>[
                //'max:50',
                'required'
            ]

        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'event.name'=>'nombre',
            'event.start_date'=>'fecha inicio',
            'event.end_date'=>'fecha fin',
        ];
        return UicFormRequest::attributes($attributes);
    }
}

