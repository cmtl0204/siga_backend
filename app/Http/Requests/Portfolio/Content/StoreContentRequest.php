<?php

namespace App\Http\Requests\Portfolio\Content;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class StoreContentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'week' => [
                '',
            ],
            'contents' => [
                '',
            ],
            'teaching_hours' => [
                '',
            ],
            'teaching_activities' => [
                '',
            ],
            'practical_hours' => [
                '',
            ],
            'practical_activities' => [
                '',
            ],
            'autonomous_hours' => [
                '',
            ],
            'autonomous_activities' => [
                '',
            ],
            'observations' => [
                '',
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
