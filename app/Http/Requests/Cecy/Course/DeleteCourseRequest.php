<?php

namespace App\Http\Requests\Cecy\Course;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;
use App\Models\Cecy\Course;
use App\Models\App\Catalogues;
class DeleteCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ids' => [
                'required',
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
