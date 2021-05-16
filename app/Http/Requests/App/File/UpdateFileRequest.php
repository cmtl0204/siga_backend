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
            'file' => [
                'required',
                'mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,txt,zip,rar,7,tar',
                'file',
                'max:102400',
            ],
            'name'=>[
                'required'
            ],
        ];
        return AppFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'file' => 'archivo',
            'name' => 'nombre',
        ];
        return AppFormRequest::attributes($attributes);
    }
}
