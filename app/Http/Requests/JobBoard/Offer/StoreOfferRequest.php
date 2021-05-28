<?php

namespace App\Http\Requests\JobBoard\Offer;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'offer.contact_name' => [
                'required',
                'min:4',
                'max:250',
            ],
            'offer.contact_email' => [
                'required',
                'min:10',
                'max:100',
                'email',
            ],
            'offer.contact_phone' => [
                'required_without:offer.contact_cellphone',
            ],
            'offer.contact_cellphone' => [
                'required_without:offer.contact_phone',
            ],
            'offer.start_date' => [
                'required',
                'date',
            ],
            // queda como array porque los json no son asi
            // ARRAY https://laravel.com/docs/8.x/validation#rule-array
            // JSON https://laravel.com/docs/8.x/validation#rule-json
            'offer.activities' => [
                'required',
                'array',
            ],
            'offer.requirements' => [
                'required',
                'array',
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
            'offer.contact_name' => 'nombre-contacto',
            'offer.contact_email' => 'email-contacto',
            'offer.contact_phone' => 'telefono-contacto',
            'offer.contact_cellphone' => 'celular-contacto',
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
