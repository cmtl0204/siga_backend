<?php

namespace App\Http\Requests\Cecy\DetailsPlanifications;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class StoreDetailsPlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'detailPlanification.date_start' => [
                'required',
                'integer',
            ],
            'detailPlanification.date_end' => [
                'required',
                'integer',
            ],
            'detailPlanification.summary' => [
                'required',
                'integer',
            ],
            'detailPlanification.planned_end_date' => [
                'required',
                'integer',
            ],
            'detailPlanification.location_certificate' => [
                'required',
                'integer',
            ],
            'detailPlanification.code_certificate' => [
                'required',
                'integer',
            ],
            'detailPlanification.capacity' => [
                'required',
                'integer',
            ],
            'detailPlanification.observation' => [
                'required',
                'integer',
            ],
            'detailPlanification.needs' => [
                'required',
                'integer',
            ],
            'detailPlanification.need_date' => [
                'required',
                'integer',
            ],
           
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'detailPlanification.date_start' => 'detailPlanification-date_start',
            'detailPlanification.date_end' => 'detailPlanification-date_end',
            'detailPlanification.summary' => 'detailPlanification-summary',
            'detailPlanification.planned_end_date' => 'detailPlanification-planned_end_date',
            'detailPlanification.location_certificate' => 'detailPlanification-location_certificate',
            'detailPlanification.code_certificate' => 'detailPlanification-code_certificate',
            'detailPlanification.capacity' => 'detailPlanification-capacity',
            'detailPlanification.observation' => 'detailPlanification-observation',
            'detailPlanification.needs' => 'detailPlanification-needs',
            'detailPlanification.need_date' => 'detailPlanification-need_date',

        ];
        return CecyFormRequest::attributes($attributes);
    }
}
