<?php

namespace App\Http\Requests\App\File;

use App\Http\Requests\App\AppFormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name'=>[
                'required'
            ],
        ];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'nombre',
        ];
        return AppFormRequest::attributes($attributes);
    }
}