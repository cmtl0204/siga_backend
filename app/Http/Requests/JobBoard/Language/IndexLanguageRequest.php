<?php

namespace App\Http\Requests\JobBoard\Language;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

class IndexLanguageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return JobBoardFormRequest::rules($rules);
    }
    public function attributes()
    {
        $attributes = [];
        return JobBoardFormRequest::attributes($attributes);
    }
}
