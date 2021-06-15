<?php

namespace App\Http\Requests\Portfolio\Unit;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class UpdateUnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'description' => [
                'required',
                'min:1',
                'max:1000',

            ],
            'order' => [
                'required',
                'min:1',
                'max:1000',

            ],
            'name' => [
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

            'description' => 'description',
            'order' => 'order',
            'name' => 'name',
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
