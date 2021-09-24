<?php

namespace App\Http\Requests\Portfolio\LearningResult;

use App\Http\Requests\Portfolio\PortfolioFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteLearningResultRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'id' => [
                '',
            ],
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'id' => 'IDs',
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
