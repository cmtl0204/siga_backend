<?php

namespace App\Http\Requests\Portfolio\Pea;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class IndexPeaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            //evaluaciónEstudiante
            'student_assessment' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'basic_bibliographies' => [
                '',
                'min:10',
                'max:1000',
            ],
            'complementary_bibliographies' => [
                '',
                'min:10',
                'max:1000',
            ]
        ];
        return PortfolioFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [

            'student_assessment' => 'student_assessment',
            'basic_biographies' => 'basic_biographies',
            'complementary_biographies' => 'complementary_biographies',
        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
