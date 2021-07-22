<?php

namespace App\Http\Requests\Cecy\Planification;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexPlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return CecyFormRequest::attributes($attributes);
    }
}  