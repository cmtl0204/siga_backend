<?php


namespace App\Http\Requests\JobBoard\Professional;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

class IndexProfessionalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'professional_id' => [
                //'required',
                'integer'
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            // 'professional_id.required' => 'El campo :attribute es obligatorio',
            'professional_id.integer' => 'El campo :attribute debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'professional_id' => 'profesional-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}