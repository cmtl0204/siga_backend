<?php

namespace App\Http\Requests\JobBoard\Offer;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'offer.code' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.contact_name' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.contact_email' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.start_date' => [
                'required',
                'date',
            ],
            'offer.activities' => [
                'required',
            ],
            'offer.requirements' => [
                'required',
            ],
            'location.id' => [
                'required',
                'integer',
            ],
            'contractType.id' => [
                'required',
                'integer',
            ],
            'position.id' => [
                'required',
                'integer',
            ],
            'sector.id' => [
                'required',
                'integer',
            ],
            'workingDay.id' => [
                'required',
                'integer',
            ],
            'experienceTime.id' => [
                'required',
                'integer',
            ],
            'trainingHours.id' => [
                'required',
                'integer',
            ],
            'status.id' => [
                'required',
                'integer',
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'offer.code' => 'codigo',
            'offer.description' => 'descripción',
            'offer.contact_name' => 'nombre-contacto',
            'offer.contact_email' => 'email-contacto',
            'offer.start_date' => 'fecha-inicio',
            'offer.activities' => 'actividades',
            'offer.requirements' => 'requerimientos',
            'location.id' => 'locacion-id',
            'contractType.id' => 'tipo-contrato-id',
            'position.id' => 'posicion-id',
            'sector.id' => 'sector-id',
            'workingDay.id' => 'dia-trabajo-id',
            'experienceTime.id' => 'tiempo-expreriencia-id',
            'trainingHours.id' => 'horas-entrenamiento-id',
            'status.id' => 'estado-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
