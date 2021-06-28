<?php

namespace App\Http\Requests\Community\ProjectObjective;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class UpdateProjectObjectiveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'project_objective.code' => [
                'min:1',
                'max:20',
                'string',
            ],
            'project_objective.description' => [
                'min:1',
                'string',
            ],
            'project_objective.verification_means' => [
                'json',
            ],
            'project.id' => [
                'integer',
            ],
            'parent.id' => [
                'integer',
            ],
            'type.id' => [
                'integer',
            ],
        ];
        return CommunityFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'project_objective.code' => 'codigo',
            'project_objective.description' => 'descripcion',
            'project_objective.verification_means' => 'medios_verificacion',
            'project.id' => 'proyecto-id',
            'parent.id' => 'padre-id',
            'type.id' => 'tipo-id',
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}