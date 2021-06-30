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
            'event.name'=>[
                'required',
                //'max:50'
            ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'event.name'=>'nombre'
        ];
        return UicFormRequest::attributes($attributes);
    }
}
