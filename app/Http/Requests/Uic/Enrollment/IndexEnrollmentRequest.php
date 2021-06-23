<?php

namespace App\Http\Requests\Uic\Enrollment;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class IndexEnrollmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return UicFormRequest::attributes($attributes);
    }
}