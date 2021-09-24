<?php

namespace App\Http\Requests\Portfolio\LearningResult;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class GetParentLearningResultRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return PortfolioFormRequest::attributes($attributes);
    }
}
