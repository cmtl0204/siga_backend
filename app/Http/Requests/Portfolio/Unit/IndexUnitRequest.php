<?php

namespace App\Http\Requests\Portfolio\Unit;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class IndexUnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'description' => [
                'min:10',
                'max:1000',

            ],
            'order' => [
                'min:10',
                'max:1000',

            ],
            'name' => [
                'min:10',
                'max:1000',

            ]
            
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'description' => 'description',
            'order' => 'order',
            'name' => 'name',
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
