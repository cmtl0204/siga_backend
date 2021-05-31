<?php

namespace App\Http\Requests\Jobboard\Reference;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreReferenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'reference.institution' => [
                'required',
                'min:5',
                'max:30'
            ],
            'reference.position' => [
                'required',
                'min:5',
                'max:30'
            ],
            'reference.contact_name' => [
                'required',
                'max:30'
            ],
            'reference.contact_phone' => [
                'required',
                'numeric',
            ],
            'reference.contact_email' => [
                'required',
                'regex:'.$this->regularExpresionEmail,
            ],
        ];

        return JobBoardFormRequest::rules($rules);
    }
    public function attributes()
    {
        $attributes = [
            'professional.id' => 'profesional-ID',
            'reference.institution' => 'institución',
            'reference.position' => 'posición',
            'reference.contact_name' => 'nombre de contacto',
            'reference.contact_phone' => 'teléfono de contacto',
            'reference.contact_email' => 'email de contacto',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
