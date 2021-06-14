<?php

namespace App\Http\Requests\Portfolio\MethodologicalStrategy;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class UpdateMethodologicalStrategyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'purpose' => [
                'required',
                'min:1',
                'max:1000',
            ]
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'purpose' => 'purpose'
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
