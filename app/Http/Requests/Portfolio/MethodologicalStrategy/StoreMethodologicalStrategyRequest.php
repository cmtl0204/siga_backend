<?php

namespace App\Http\Requests\Portfolio\MethodologicalStrategy;

use App\Http\Requests\Portfolio\PortfolioFormRequest;
use Illuminate\Foundation\Http\FormRequest;
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

        return PortfolioFormRequest::rules($rules);
        ];
    }
    public function attributes()

    {
        $attributes = [


            'purpose' => 'purpose',
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
