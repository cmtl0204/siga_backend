<?php

namespace App\Http\Requests\Portfolio\Content;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class IndexContentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'week' => [
                'min:10',
                'max:1000',

            ],
            'contents' => [
                'min:10',
                'max:1000',

            ],
            'teaching_hours' => [
                'min:10',
                'max:1000',

            ],
            'teaching_activities' => [
                'min:10',
                'max:1000',

            ],
            'practical_hours' => [
                'min:10',
                'max:1000',

            ],
            'practical_activities' => [
                'min:10',
                'max:1000',

            ],
            'autonomous_hours' => [
                'min:10',
                'max:1000',

            ],
            'autonomous_activities' => [
                'min:10',
                'max:1000',

            ],
            'observations' => [
                'min:10',
                'max:1000',

            ]

        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'week' => 'description',
            'contents' => 'description',
            'teaching_hours' => 'description',
            'teaching_activities' => 'description',
            'practical_hours' => 'description',
            'practical_activities' => 'description',
            'autonomous_hours' => 'description',
            'autonomous_activities' => 'description',
            'observations' => 'description'
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
