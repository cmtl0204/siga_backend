<?php

namespace App\Http\Requests\Cecy\Prerequisite;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class UpdatePrerequisiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'course.id' => [
                'required',
                'integer',
            ],
            'state.id' => [
                'required',
                'integer',
            ],
            'parent_code.id' => [
                'required',
                'integer',
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'course.id' => 'course-id',
            'state.id' => 'state-id',
            'Parent_code.id' => 'Parent_code-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
