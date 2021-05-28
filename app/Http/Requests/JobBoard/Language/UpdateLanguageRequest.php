<?php

namespace App\Http\Requests\JobBoard\Language;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;


class UpdateLanguageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'idiom.id' => [
                'required',
                'integer',
            ],
            'writtenLevel.id' => [
                'required',
                'integer',
            ],
            'spokenLevel.id' => [
                'required',
                'integer',
            ],
            'readLevel.id' => [
                'required',
                'integer',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'idiom.id.required' => 'El campo :attribute es obligatorio',
            'idiom.id.integer' => 'El campo :attribute debe ser numérico',
            'writtenLevel.id.required' => 'El campo :attribute es obligatorio',
            'writtenLevel.id.integer' => 'El campo :attribute debe ser numérico',
            'spokenLevel.id.required' => 'El campo :attribute es obligatorio',
            'spokenLevel.id.integer' => 'El campo :attribute debe ser numérico',
            'readLevel.id.required' => 'El campo :attribute es obligatorio',
            'readLevel.id.integer' => 'El campo :attribute debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'professional.id' => 'profesional-ID',
            'idiom.id' => 'idioma-ID',
            'writtenLevel.id' => 'nivel escritura-ID',
            'spokenLevel.id' => 'nivel hablado-ID',
            'readLevel.id' => 'nivel lectura-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
