<?php

namespace App\Http\Requests\Cecy\DetailsPlanifications;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexDetailsPlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            //'institution_id' => [
             //   'required',
             //   'integer'
           // ],
        ];
        return CecyFormRequest::rules($rules);
    }

    //public function messages()
    //{
       // $messages = [
      //      'institution_id.required' => 'El campo :attribute es obligatorio',
            //'institution_id.integer' =>'El campo :attribute debe ser numérico',
      //  ];
        
   // }

    public function attributes()
    {
        $attributes = [
           // 'institution_id' => 'institution-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
