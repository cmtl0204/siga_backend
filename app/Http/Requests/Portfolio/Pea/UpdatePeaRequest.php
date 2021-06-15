<?php

namespace App\Http\Requests\Portfolio\Pea;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class UpdatePeaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            //evaluaciónEstudiante
            'subject.id' => [
                '',
                'integer',
                'max:1000',
            ],
            'school_period.id' => [
                '',
                'integer',
                'max:1000',
            ],
            'student_assessment' => [
                '',
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

            'pea.subject.id' => 'pea.subject.id',
            'pea.school_period.id' => 'pea.school_period.id',
            'pea.student_assessment' => 'pea.student_assessment',
            'pea.basic_bibliographies' => 'pea.basic_bibliographies',
            'pea.complementary_bibliographies' => 'pea.complementary_bibliographies',

        ];
        return PortfolioFormRequest::attributes($attributes);
    }
}
