<?php

namespace App\Http\Requests\Cecy\DetailsPlanifications;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;

class DeleteDetailsPlanificationeRequest extends FormRequest
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
