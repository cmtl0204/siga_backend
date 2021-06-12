<?php

namespace App\Http\Requests\Portfolio\DidacticResource;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class IndexDidacticResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [

            'resources' => [
                'required',
                'min:10',
                'max:1000',
            ],

        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'resources' => 'resources',

        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
