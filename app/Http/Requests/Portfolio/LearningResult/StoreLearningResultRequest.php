<?php

namespace App\Http\Requests\Portfolio\LearningResult;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class StoreLearningResultRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'learning_result.code' => [
                '',
                'min:',
                'max:1000',
            ],
            'learning_result.description' => [
                '',
                'min:',
                'max:1000',
            ],
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'learning_result.code' => 'code',
            'learning_result.description' => 'description',
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
