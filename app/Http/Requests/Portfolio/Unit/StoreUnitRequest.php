<?php

namespace App\Http\Requests\Portfolio\Unit;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class StoreUnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            
            'description' => [
                '',

            ],
            'order' => [
                '',

            ],
            'name' => [
                '',

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
