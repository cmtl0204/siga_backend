<?php

namespace App\Http\Requests\JobBoard\Reference;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReferenceRequest extends FormRequest
{
    private $regularExpresionEmail = '/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'reference.institution' => [
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
            'reference.institution' => 'institución',
            'reference.position' => 'posición',
            'reference.contact_name' => 'nombre de contacto',
            'reference.contact_phone' => 'teledono de contacto',
            'reference.contact_email' => 'email de contacto',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
