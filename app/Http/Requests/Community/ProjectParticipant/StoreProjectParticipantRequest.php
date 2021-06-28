<?php

namespace App\Http\Requests\Community\ProjectParticipant;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class StoreProjectParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'project_participant.start_date' => [
                'date',
            ],
            'project_participant.end_date' => [
                'date',
            ],
            'project_participant.schedule_job' => [
                'max:20',
                'string',
            ],
            'project_participant.position' => [
                'string',
            ],
            'project_participant.working_hours' => [
                'integer',
            ],
            'project_participant.functions' => [
                'json',
            ],
            'project.id' => [
                'integer',
            ],
            'user.id' => [
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
            'project_participant.start_date' => 'fecha_inicio',
            'project_participant.end_date' => 'fecha_final',
            'project_participant.schedule_job' => 'horario_trabajo',
            'project_participant.position' => 'posicion',
            'project_participant.working_hours' => 'horas_trabajo',
            'project_participant.functions' => 'funciones',
            'project.id' => 'proyecto-id',
            'user.id' => 'usuario-id',
            'type.id' => 'tipo-id',
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}