<?php

namespace App\Http\Requests\JobBoard\Skill;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
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
            'skill.type.id' => [
                'required',
                'integer',
//                Rule::unique('pgsql-job-board.skills', 'type_id')->ignore($this->id),
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'skill.description' => 'descripción',
            'skill.type.id' => 'tipo-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
