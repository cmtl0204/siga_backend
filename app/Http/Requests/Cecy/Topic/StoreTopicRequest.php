<?php

namespace App\Http\Requests\Cecy\Topic;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Topic;
use App\Models\App\Type;

class StoreTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'topics.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'topics.parent_code_id' => [
                'required',
                'integer',
            ],
            'topics.course_id' => [
                'required',
                'integer',

            ],
            'topics.type.id' => [
               'required',
               'integer',
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'topics.description' => 'descripción',
            'topics.parent_code_id' => 'code-ID',
            'topics.course_id' => 'course-ID',
            'topics.type.id' => 'tipo-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}