<?php

namespace App\Http\Requests\Cecy\Topic;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UodateTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'topic.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'parent_code.id' => [
                'required',
                'integer',
            ],
            'course.id' => [
                'required',
                'integer',

            ],
            'type.id' => [
               'required',
               'integer',
            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        public function attributes()
    {
        $attributes = [
            'topic.description' => 'descripción',
            'parent_code.id' => 'code-ID',
            'course.id' => 'course-ID',
            'type.id' => 'tipo-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
