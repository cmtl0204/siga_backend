<?php

namespace App\Http\Requests\App\Career;

use App\Http\Requests\App\AppFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCareerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ids' => [],
        ];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return AppFormRequest::attributes($attributes);
    }
}
