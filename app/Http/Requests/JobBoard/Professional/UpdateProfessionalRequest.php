<?php

namespace App\Http\Requests\JobBoard\Professional;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessionalRequest extends FormRequest
{
    private $regularExpresionEmail = '/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/';

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            // 'professional.user.address.main_street' => [
            //     'required',
            //     'string',


            // ],
            // 'professional.user.address.secondary_street' => [
            //     'required',
            //     'string',
            // ],
            // 'professional.user.address.number' => [],
            // 'professional.user.address.post_code' => [],
            // 'professional.user.address.reference' => [],
            // 'professional.user.address.longitude' => [],
            // 'professional.user.address.latitude' => [],


            'professional.user.identification' => [
                'required',
                'min:10',
                'max:15',
            ],
            'professional.user.names' => [
                'required',
                'min:2',
            ],
            'professional.user.email' => [
                'required',
                'regex:' . $this->regularExpresionEmail,
            ],
            'professional.user.phone' => [
                'required',
                'min:10',
            ],
            'professional.user.first_lastname' => [
                'required',
                'min:2',

            ],
            'professional.user.second_lastname' => [
                'required',
                'min:2',

            ],
            'professional.user.gender' => [
                'required',
            ],
            'professional.user.sex' => [
                'required',
            ],

            'professional.is_travel' => [
                'required',
                'boolean',
            ],
            'professional.is_disability' => [
                'required',
                'boolean',
            ],
            'professional.is_familiar_disability' => [
                'required',
                'boolean',
            ],
            'professional.identification_familiar_disability' => [
                'required',
                'string',
            ],
            'professional.is_catastrophic_illness' => [
                'required',
                'boolean',
            ],
            'professional.is_familiar_catastrophic_illness' => [
                'required',
                'boolean',
            ],
            'professional.about_me' => [
                'required',
                'min:10',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }


    public function attributes()
    {
        $attributes = [
            'professional.user.address.main_street' => 'calle principal',
            'professional.user.address.secondary_street' => 'calle secundaria',
            'professional.user.names' => 'nombre de usuario',
            'professional.user.identification' => 'identificacion',
            'professional.user.email' => 'email',
            'professional.user.sex' => 'sexo ',
            'professional.user.gender' => 'genero',
            'professional.user.phone' => 'nombre de usuario',
            'professional.is_travel' => 'puede viajar',
            'professional.is_disability' => 'tiene discapacidad',
            'professional.is_familiar_disability' => 'tiene discapacidad familiar',
            'professional.identification_familiar_disability' => 'identificacion de discapacidad familiar',
            'professional.is_catastrophic_illness' => 'tiene una enfermedad catastrofica',
            'professional.is_familiar_catastrophic_illness' => 'tiene un  familiar con enfermedad catastrofica ',
            'professional.abou_me' => 'acerca de mì',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}