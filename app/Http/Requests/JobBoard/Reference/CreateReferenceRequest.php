<?php

namespace App\Http\Requests\JobBoard\Reference;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateReferenceRequest extends FormRequest
{
    private $regularExpresionEmail = '/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
           'reference.institution.id' => [
                'required',
               
               
            ],
            'reference.position' => [
                'required',
               
            ],
            'reference.contact_name' => [
                'required',
               
            ],
            'reference.contact_phone' => [
                'required',
             
            ],
            'reference.contact_email' => [
                'required',
             
                'regex:'.$this->regularExpresionEmail,
            ]
        ];

        return JobBoardFormRequest::rules($rules);
    }

   

    public function attributes()
    {
        $attributes = [
      
            'reference.institution.id' => 'institución',
            'reference.position' => 'posición',
            'reference.contact_name' => 'nombre de contacto',
            'reference.contact_phone' => 'teléfono de contacto',
            'reference.contact_email' => 'email de contacto',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }

}
