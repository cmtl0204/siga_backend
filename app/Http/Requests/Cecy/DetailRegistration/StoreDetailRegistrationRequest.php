<?php

namespace App\Http\Requests\Cecy\DetailRegistration;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\DetailRegistration;
use App\Models\App\Status;

class StoreDetailRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'z.partial_grade' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'detailRegistration.final_exam' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'detailRegistration.code_certificate' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'detailRegistration.certificate_withdrawn' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'detailRegistration.location_certificate' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'detailRegistration.observation' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'detailRegistration.registration_id' => [
                'required',
                'integer',
            ],
            'detailRegistration.additional_information_id' => [
                'required',
                'integer',
//                Rule::unique('pgsql-job-board.skills', 'type_id')->ignore($this->id),
            ],
            'detailRegistration.detail_planification_id' => [
                'required',
                'integer',
            ],
            'detailRegistration.status.id' => [
                'required',
                'integer',
            ],
            'detailRegistration.status_certificate.id' => [
                'required',
                'integer',
            ],
            'detailRegistration.registration_id' => [
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
            'detail_registrations.registration.id' => 'registration-id',
            'detail_registrations.additional_information.id' => 'additional_information-id',
            'detail_registrations.detail_planification_id' => 'detail_planification-id',
            'detail_registrations.staus.id' => 'staus-id',
            'detail_registrations.status_certificate.id' => 'status_certificate-id',
            'detail_registrations.registration.id' => 'registration-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}