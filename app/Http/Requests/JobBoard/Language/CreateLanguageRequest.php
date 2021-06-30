<?php

namespace App\Http\Requests\JobBoard\Language;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateLanguageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'language.idiom.id' => [
                'required',
          
            ],
            'language.written_level.id' => [
                'required',
            
            ],
            'language.spoken_level.id' => [
                'required',
        
            ],
            'language.read_level.id' => [
                'required',
               
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }
 
    public function attributes()
    {
        $attributes = [
            'language.idiom.id' => 'idioma-ID',
            'language.written_level.id' => 'nivel escritura-ID',
            'language.spoken_level.id' => 'nivel hablado-ID',
            'language.read_level.id' => 'nivel lectura-ID',
       
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
