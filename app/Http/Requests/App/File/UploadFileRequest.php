<?php

namespace App\Http\Requests\App\File;

use App\Http\Requests\App\AppFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'id' => [
                'required'
            ],
            'files.*' => [
                'required',
                'mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,txt,zip,rar,7z,tar',
                'file',
                'max:1024000',
            ],
        ];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'files.*' => 'archivo'
        ];
        return AppFormRequest::attributes($attributes);
    }
}
