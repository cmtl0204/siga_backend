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
            'code' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'description' => [
                '',
                'min:10',
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
