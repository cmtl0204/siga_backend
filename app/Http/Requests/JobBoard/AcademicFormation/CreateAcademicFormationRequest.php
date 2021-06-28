<?php

namespace App\Http\Requests\JobBoard\AcademicFormation;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateAcademicFormationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
         
        ];
        return JobBoardFormRequest::rules($rules);
    }


    public function attributes()
    {
        $attributes = [
        
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}