<?php

namespace App\Http\Requests\DetailRegistration;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class StoreDetailRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'detail_registrations.partial_grade' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'detail_registrations.final_exam' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'detail_registrations.code_certificate' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'detail_registrations.certificate_withdrawn' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'detail_registrations.location_certificate' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'detail_registrations.observation' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'registration.id' => [
                'required',
                'integer',
            ],
            'additional_information.id' => [
                'required',
                'integer',
//                Rule::unique('pgsql-job-board.skills', 'type_id')->ignore($this->id),
            ]
            'detail_planification.id' => [
                'required',
                'integer',
            ],
            'staus.id' => [
                'required',
                'integer',
            ],
            'status_certificate.id' => [
                'required',
                'integer',
            ],
            'registration.id' => [
                'required',
                'integer',
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'detail_registrations.partial_grade' => 'partial_grade',
            'detail_registrations.final_exam' => 'final_exam',
            'detail_registrations.code_certificate' => 'code_certificate',
            'detail_registrations.certificate_withdrawn' => 'certificate_withdrawn',
            'detail_registrations.location_certificate' => 'location_certificate',
            'detail_registrations.observation' => 'observation',
            'registration.id' => 'registration-id',
            'additional_information.id' => 'additional_information-id',
            'detail_planification.id' => 'detail_planification-id',
            'staus.id' => 'staus-id',
            'status_certificate.id' => 'status_certificate-id',
            'registration.id' => 'registration-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}