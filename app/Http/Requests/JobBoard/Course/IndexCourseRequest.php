<?php

namespace App\Http\Requests\JobBoard\Course;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

class IndexCourseRequest extends FormRequest
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
