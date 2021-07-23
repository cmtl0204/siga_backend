<?php

namespace App\Http\Requests\Cecy\Planification;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'planification.id' => [
            ],
          
            'planification.date_start' => [
                'required'
            ],
            'planification.date_end' => [
                'required'
            ],
            'planification.course.id' => [
                'required'
            ],
            'planification.needs' => [
                'required'
            ], 'planification.user.id' => [
                'required'
            ],
            'planification.status.id' => [
                'required'
            ],
        
        ];

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
            'planification.date_start' => 'date_start',
            'planification.date_end' => 'date_end',
            'planification.course.id' => 'course_id',
            'planification.needs' => 'needs',
            'planification.user.id' => 'user_id',
            'planification.status.id' => 'status_id',          
        ];

        return CecyFormRequest::rules($attributes);
    } 
}
