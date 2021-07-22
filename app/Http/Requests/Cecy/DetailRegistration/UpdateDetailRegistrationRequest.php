<?php

namespace App\Http\Requests\Cecy\DetailRegistration;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\DetailRegistration;
use App\Models\App\Status;

class UpdateDetailRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'detailRegistration.partial_grade1' => [
                
                'min:1',
                'max:1000',
            ],
            'detailRegistration.partial_grade2' => [
                
                'min:1',
                'max:1000',
            ],
            'detailRegistration.final_note' => [
                
                'min:1',
                'max:1000',
            ],
            'detailRegistration.code_certificate' => [
                
                'min:1',
                'max:1000',
            ],
            'detailRegistration.certificate_withdrawn' => [
                
                'min:1',
                'max:1000',
            ],
            'detailRegistration.location_certificate' => [
                
                'min:1',
                'max:1000',
            ],
            'detailRegistration.observation' => [
                
                'min:1',
                'max:1000',
            ],

            'detailRegistration.registration.id' => [
                
                'integer',
            ],
            
            'detailRegistration.additional_information.id' => [
                
                'integer',
            ],
            'detailRegistration.detail_planification.id' => [
                
                'integer',
            ],
            'detailRegistration.status.id' => [
                
                'integer',
            ],
            'detailRegistration.status_certificate.id' => [
                
                'integer',
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'detailRegistration.partial_grade1' => 'partial_grade1',
            'detailRegistration.partial_grade2' => 'partial_grade2',
            'detailRegistration.final_note' => 'final_note',
            'detailRegistration.code_certificate' => 'code_certificate',
            'detailRegistration.certificate_withdrawn' => 'certificate_withdrawn',
            'detailRegistration.location_certificate' => 'location_certificate',
            'detailRegistration.observation' => 'observation',
            'detailRegistration.registration.id' => 'registration-id',
            'detailRegistration.additional_information.id' => 'additional_information-id',
            'detailRegistration.detail_planification.id' => 'detail_planification-id',
            'detailRegistration.status.id' => 'status-id',
            'detailRegistration.status_certificate.id' => 'status_certificate-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}