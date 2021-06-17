<?php

namespace App\Http\Requests\Cecy\Registration;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'registration.date_registration' => [
                'required'
            ],
            'registration.number' => [
                'required',
                'min:10',
            ],
            'registration.planification_id'=> [
                'required',
                'integer'
            ],
            'registration.status.id'=> [
                'required',
                'integer'
            ],
            'registration.type.id'=> [
                'required',
                'integer'
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'registration.date' => 'fecha',
            'registration.number' => 'Tipo numberdebe tener minimo de 10 letras y ',
            'registration.participant_id' => 'participante',
            'registration.status_id' => 'estado',
            'registration.type_id' => 'tipo',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}