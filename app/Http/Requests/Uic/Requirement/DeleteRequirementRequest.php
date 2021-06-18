<?php

namespace App\Http\Requests\Uic\Requirement;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequirementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ids' => [ ],
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return UicFormRequest::attributes($attributes);
    }
}