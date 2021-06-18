<?php

namespace App\Http\Requests\Cecy\Institutions;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class CreateInstitutionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'institution.institution_id' => [
                'required',
                'integer',
            ],
            'institution.authority_id' => [
                'required',
                'integer',
            ],
           
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'institution.institution_id' => 'institution-id',
            'institution.authority_id' => 'authority-id',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
