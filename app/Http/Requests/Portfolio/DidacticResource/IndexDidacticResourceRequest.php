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
<<<<<<< HEAD
            'resources' => [
                'min:10',
                'max:1000',
            ]
            
=======

            'resources' => [
                'required',
                'min:10',
                'max:1000',
            ],

>>>>>>> u_7_duque-marcelo
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

<<<<<<< HEAD
            'resources' => 'resources'
=======
            'resources' => 'resources',

>>>>>>> u_7_duque-marcelo
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
