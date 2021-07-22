<?php

namespace App\Http\Requests\Cecy\Attendance;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'attendances.detail_registration_id' => [
                'required',
                'min:1',
                'max:1000',
            ],
            'attendances.date' => [
                'required',
                'date',
            ],
            'attendances.day_hours' => [
                'required',
                'integer',

            ],

            'attendances.assistance' => [
                'required',
                'boolean',

            ],

            'attendances.observations' => [
                'required',
                'min:1',
                'max:1000',
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'attendances.detail_registration_id' => 'detail-ID',
            'attendances.date' => 'date',
            'attendances.day_hours' => 'day_hours',
            'attendances.assistance' => 'assistance',
            'attendances.observations' => 'observation',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}