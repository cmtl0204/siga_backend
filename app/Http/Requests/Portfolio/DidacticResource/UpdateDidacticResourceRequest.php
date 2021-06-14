<?php

namespace App\Http\Requests\Portfolio\DidacticResource;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class UpdateDidacticResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'resources' => [
                '',
            ],
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'resources' => 'resources'           
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
