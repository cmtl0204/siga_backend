<?php

namespace App\Http\Requests\Cecy\Institutions;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;
use App\Models\Cecy\Institutions;
use App\Models\App\Institution;
class DeleteInstitutioneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'id' => [
                'required',
            ],
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'id' => 'ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
