<?php

namespace App\Http\Requests\Community\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class VinculationRequestDocRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => [
                'min:1',
                'max:70',
                'string',
            ],
            'ci' => [
                'min:8',
                'max:12',
                'string',
            ],
            'career.name' => [
                'string',
            ],
            'institution' => [
                'string',
            ],
            'date' => [
                'date',
            ],
            'logo' => [
                'string',
            ],
        ];
        return CommunityFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'nombre',
            'ci' => 'ci',
            'career.name' => 'nombre_carrera',
            'level' => 'nivel',
            'entity' => 'entidad',
            'institution' => 'institucion',
            'logo' => 'logo',
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}