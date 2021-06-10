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
            'professional_id' => [
                'required',
                'integer'
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'professional_id.required' => 'El campo :attribute es obligatorio',
            'professional_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        
    }

    public function attributes()
    {
        $attributes = [
            'professional_id' => 'profesional-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
