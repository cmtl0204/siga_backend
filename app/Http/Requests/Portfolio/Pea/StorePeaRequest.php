<?php

namespace App\Http\Requests\Portfolio\Pea;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class StorePeaRequest extends FormRequest
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
                '',

            ],
            'basic_bibliographies' => [
                '',

            ],
            'complementary_bibliographies' => [
                '',

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
