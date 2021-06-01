<?php

namespace App\Http\Requests\Jobboard\Language;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'professional.id' => [
                'required',
                'integer',
            ],
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
