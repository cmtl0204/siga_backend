<?php

namespace App\Http\Requests\Community\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class PortfolioSecondDocRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'receiver' => [
                'min:1',
                'max:70',
                'string',
            ],
            'sender' => [
                'min:1',
                'max:70',
                'string',
            ],
            'ci' => [
                'min:8',
                'max:12',
                'string',
            ],
            'project' => [
                'string',
            ],
            'career' => [
                'string',
            ],
            'start_date' => [
                'date',
            ],
            'description' => [
                'string',
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
            'sender' => 'emisor',
            'receiver' => 'receptor',
            'ci' => 'ci',
            'career' => 'carrera',
            'project' => 'proyecto',
            'start_date' => 'fecha_inicio',
            'description' => 'descripcion',
            'logo' => 'logo',
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}