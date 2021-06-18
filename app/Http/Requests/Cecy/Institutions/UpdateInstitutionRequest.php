<?php

namespace App\Http\Requests\Cecy\Institutions;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;
class UpdateInstitutionRequest extends FormRequest
{
      public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'institution.ruc' => [
                'required',
                
            ],
            'institution.logo' => [
                'required',
                
            ],
            'institution.name' => [
                'required',
                
            ],
            'institution.slogan' => [
                'required',
                
            ],
            'institution.code' => [
                'required',
                
            ],
           
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'institution.ruc' => 'institution-ruc',
            'institution.logo' => 'institution-logo',
            'institution.name' => 'institution-name',
            'institution.slogan' => 'institution-slogan',
            'institution.code' => 'institution-code',



        ];
        return CecyFormRequest::attributes($attributes);
    }
}
