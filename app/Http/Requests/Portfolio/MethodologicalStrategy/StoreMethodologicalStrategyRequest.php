<?php

namespace App\Http\Requests\Portfolio\MethodologicalStrategy;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class StoreMethodologicalStrategyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [

            'purpose' => [
                '',

            ],

        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'purpose' => 'purpose',

        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
