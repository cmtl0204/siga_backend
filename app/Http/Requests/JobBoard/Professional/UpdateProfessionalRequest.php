<?php

namespace App\Http\Requests\JobBoard\Professional;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessionalRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'professional.user.address.main_street' => [
                'required'
            ],
            'professional.user.address.secondary_street' => [
                'required'
            ],
            'professional.user.address.number' => [],
            'professional.user.address.post_code' => [],
            'professional.user.address.reference' => [],
            'professional.user.address.longitude' => [],
            'professional.user.address.latitude' => [],

            'professional.user.identification_type.id' => [
                'required',
                'integer',
            ],
            'professional.user.identification' => [
                'required',
                'min:10',
                'max:15',
            ],
            'professional.user.email' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'professional.user.phone' => [
                'required',
                'min:10',
                'max:15',
            ],
            'professional.user.firstLastname' => [
                'required',
                'min:10',
                'max:15',
            ],
            'professional.user.secondLastname' => [
                'required',
                'min:10',
                'max:15',
            ],


            'professional.has_travel' => [
                'required',
                'boolean',
            ],
            'professional.hasDisability' => [
                'required',
                'boolean',
            ],
            'professional.hasFamiliarDisability' => [
                'required',
                'boolean',
            ],
            'professional.identificationFamiliarDisability' => [
                'required',
                'boolean',
            ],
            'professional.hasCatastrophicIllness' => [
                'required',
                'boolean',
            ],
            'professional.hasFamiliarCatastrophicIllness' => [
                'required',
                'boolean',
            ],
            'professional.aboutMe' => [
                'required',
                'min:20',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }


    public function attributes()
    {
        $attributes = [

            'professional.has_travel' => 'puede viajar',
            'professional.hasDisability' => 'tiene discapacidad',
            'professional.hasFamiliarDisability' => 'tiene discapacidad familiar',
            'professional.identificationFamiliarDisability' => 'identificacion de discapacidad familiar',
            'professional.hasCatastrophicIllness' => 'tiene una enfermedad catastrofica',
            'professional.hasFamiliarCatastrophicIllness' => 'tiene un  familiar con enfermedad catastrofica ',
            'professional.abouMe' => 'acerca de mì',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}