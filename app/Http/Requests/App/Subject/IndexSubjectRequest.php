<?php

namespace App\Http\Requests\App\Subject;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\App\AppFormRequest;

class IndexSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            //subjects
            'description' => [
                '',
                'min:10',
                'max:1000',
            ],
            'objective' => [
                '',
                'min:10',
                'max:1000',
            ],

        ];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'description' => 'description',
            'objective' => 'objective',

        ];
        return AppFormRequest::attributes($attributes);
    }
}
