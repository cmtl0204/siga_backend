<?php

namespace App\Http\Requests\Authentication;

class DetailEvaluationFormRequest
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
            'result' = => [
                'required',
                'double',

            ],
            return DetailEvaluationFormRequest::rules($rules);
        ]
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
