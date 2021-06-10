<?php

namespace App\Http\Requests\Authentication;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TeacherEval\DetailEvaluation;

class IndexDetailEvaluationFormRequest
{
    public static function rules($rules = [])
    {
       /* return array_merge($rules, [
            'per_page' => [
                'integer',
                'min:1',
                'max:100',
            ],
            'page' => [
                'integer',
            ],
            'search' => [
                'min:3',
                'max:100',
            ],
        ]);*/

        $rules = [
            'evaluation_id' = => [
                'required',
                'integer'
            ],



        ];

        return IndexDetailEvaluationRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'evaluation_id' => 'El campo :attribute es obligatorio',

        ];
        return IndexDetailEvaluationRequest::messages($messages);
    }



    public static function attributes($attributes = [])
    {
        return array_merge($attributes, [
            'per_page' => 'por página',
            'page' => 'página',
            'search' => 'búsqueda',
        ]);
    }
}
