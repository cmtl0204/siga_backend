<?php

namespace App\Http\Requests\JobBoard\Reference;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteReferenceRequest extends FormRequest
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
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'ids' => 'IDs',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
