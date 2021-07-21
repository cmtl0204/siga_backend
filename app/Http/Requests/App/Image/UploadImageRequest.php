<?php

namespace App\Http\Requests\App\Image;

use App\Http\Requests\app\AppFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'images.*' => [
                'required',
                'mimes:jpg,jpeg,png,jpeg 2000,bmp',
                'file',
                'max:102400',
            ],
        ];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'images.*' => 'imagen'
        ];
        return AppFormRequest::attributes($attributes);
    }
}
