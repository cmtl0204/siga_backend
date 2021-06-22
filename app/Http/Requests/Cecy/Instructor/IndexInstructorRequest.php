<?php

namespace App\Http\Requests\Cecy\Instructor;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'user_id' => [
                'required',
                'integer'
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'user_id.required' => 'El campo :attribute es obligatorio',
            'user_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        
    }

    public function attributes()
    {
        $attributes = [
            'user_id' => 'user-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
