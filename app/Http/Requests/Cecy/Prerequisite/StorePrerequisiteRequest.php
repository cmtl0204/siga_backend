<?php

namespace App\Http\Requests\Cecy\Prerequisite;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class StorePrerequisiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'prerequisite.course_id' => [
                'required',
                'integer',
            ],
            'prerequisite.state.id' => [
                'required',
                'integer',
            ],
            'prerequisite.parent_code_id' => [
                'required',
                'integer',
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'prerequisite.course_id' => 'course-id',
            'prerequisite.state.id' => 'state-id',
            'prerequisite.parent_code_id' => 'Parent_code-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
