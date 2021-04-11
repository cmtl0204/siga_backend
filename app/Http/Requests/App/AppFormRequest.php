<?php

namespace App\Http\Requests\App;

class AppFormRequest
{
    public static function rules($rules = [])
    {
        return array_merge($rules, [
            'per_page' => [
                'integer',
                'min:1',
                'max:100',
            ],
            'search' => [
                'min:3',
                'max:100',
            ]
        ]);
    }

    public static function messages($messages = [])
    {
        return array_merge($messages, [
            'per_page.integer' => 'El campo :attribute debe ser un número',
            'per_page.min' => 'El campo :attribute debe ser al menos :min',
            'per_page.max' => 'El campo :attribute no puede ser mayor que :max',
            'search.min' => 'El campo :attribute debe tener al menos :min caracteres',
        ]);
    }

    public static function attributes($attributes = [])
    {
        return array_merge($attributes, [
            'per_page' => 'por página',
            'search' => 'búsqueda',
        ]);
    }
}
