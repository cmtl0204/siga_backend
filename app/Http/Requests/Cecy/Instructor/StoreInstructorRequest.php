<?php

namespace App\Http\Requests\Cecy\Instructor;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;
use App\Model\Authentication\User;
use App\Model\App\Catalogue;

class StoreInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'instructor.user.id' => [
                'required',
                'integer',
            ],
            'instructor.responsible.id' => [
                'required',
                'integer',
            ],
            'instructor.type_instructor.id' => [
                'required',
                'integer',

            ]
        ];
        return CecyFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'instructors.user.id' => 'usuario-ID',
            'instructors.responsible.id' => 'responsable-ID',
            'instructors.type_instructor.id' => 'tipo-ID',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
