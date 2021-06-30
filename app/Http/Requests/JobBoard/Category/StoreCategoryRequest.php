<?php

namespace App\Http\Requests\JobBoard\Category;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'category.code' => [
                'required',
                'min:3',
                'max:20',
            ],
            'category.name' => [
                'required',
                'min:3',
                'max:250',
            ],
            'category.parent.id' => [
               // 'required',
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'category.code' => 'código',
            'category.name' => 'nombre',
            'category.parent.id' => 'CategoriaID'
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
