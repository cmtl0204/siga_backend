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

    public function messages()
    {
        $messages = [
            'professional.has_travel.required' => 'El campo :attribute es obligatorio',
            'professional.has_travel.boolean' => 'El campo :attribute debe ser true o false',
            'professional.hasDisability.required' => 'El campo :attribute es obligatorio',
            'professional.hasDisability.boolean' => 'El campo :attribute debe ser numérico',
            'professional.hasFamiliarDisability.required' => 'El campo :attribute es obligatorio',
            'professional.hasFamiliarDisability.boolean' => 'El campo :attribute debe ser numérico',
            'professional.identificationFamiliar_disability.required' => 'El campo :attribute es obligatorio',
            'professional.identificationFamiliar_disability.boolean' => 'El campo :attribute debe ser numérico',
            'professional.hasCatastrophicIllness.required' => 'El campo :attribute es obligatorio',
            'professional.hasCatastrophicIllness.boolean' => 'El campo :attribute debe ser numérico',
            'professional.hasFamiliarCatastrophicIllness.required' => 'El campo :attribute es obligatorio',
            'professional.hasFamiliarCatastrophicIllness.boolean' => 'El campo :attribute debe ser numérico',
            'professional.aboutMe.required' => 'El campo :attribute es obligatorio',
            'professional.aboutMe.min' => 'El campo :attribute debe tener al menos :min caracteres',
        ];
        return JobBoardFormRequest::messages($messages);
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