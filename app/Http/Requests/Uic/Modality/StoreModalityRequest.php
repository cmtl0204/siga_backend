<?php

namespace App\Http\Requests\Uic\Modality;

use App\Http\Requests\Uic\UicFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreModalityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
//             'skill.description' => [
//                 'required',
//                 'min:10',
//                 'max:1000',
//             ],
//             'skill.type.id' => [
//                 'required',
//                 'integer',
// //                Rule::unique('pgsql-job-board.skills', 'type_id')->ignore($this->id),
//             ]
        ];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            // 'skill.description' => 'descripción',
            // 'skill.type.id' => 'tipo-id',
        ];
        return UicFormRequest::attributes($attributes);
    }
}