<?php

namespace App\Http\Requests\App\Career;

use App\Http\Requests\App\AppFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCareerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return AppFormRequest::attributes($attributes);
    }
}
