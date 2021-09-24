<?php

namespace App\Http\Requests\Portfolio\LearningResult;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class IndexLearningResultRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [

            'code' => [
                '',
                'min:1',
                'max:1000',
            ],
            'description' => [
                '',
                'min:1',
                'max:1000',
            ],

        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'code' => 'code',
            'description' => 'description',

        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}