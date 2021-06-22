<?php

namespace App\Http\Requests\Cecy\Prerequisite;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexPrerequisiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'course_id' => [
                'required',
                'integer'
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'course_id.required' => 'El campo :attribute es obligatorio',
            'course_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        
    }

    public function attributes()
    {
        $attributes = [
            'course_id' => 'course-ID',
        ];
        
    }
}
