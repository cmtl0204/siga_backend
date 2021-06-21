<?php

namespace App\Http\Requests\Cecy\Topic;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'parent_code_id' => [
                'required',
                'integer'
            ],
        ];  
        return CecyFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'parent_code_id.required' => 'El campo :attribute es obligatorio',
            'parent_code_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        return CecyFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'parent_code_id' => 'parent_code-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
