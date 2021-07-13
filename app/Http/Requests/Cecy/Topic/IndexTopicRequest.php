<?php

namespace App\Http\Requests\Cecy\Topic;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class IndexTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return FormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return FormRequest::attributes($attributes);
    }
}