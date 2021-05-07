<?php

namespace App\Http\Requests\JobBoard\Skill;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'skill.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'type.id' => [
                'required',
                'integer',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'skill.description' => 'descripción',
            'type.id' => 'tipo-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
