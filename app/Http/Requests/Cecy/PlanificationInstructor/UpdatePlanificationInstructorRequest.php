<?php

namespace App\Http\Requests\Cecy\PlanificationInstructor;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificationInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'planification_instructor.instructor_id' => [
                'required',
                'integer'
            ],
            'planification_instructor.planification_id' => [
                'required',
                'integer'
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'planification_instructor.instructor_id' => 'instructor',
            'planification_instructor.planification_id' => 'planification',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}