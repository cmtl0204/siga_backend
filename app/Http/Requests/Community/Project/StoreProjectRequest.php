<?php

namespace App\Http\Requests\Community\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'project.code' => [
                'min:1',
                'max:100',
                'string',
            ],
            'project.title' => [
                'min:5',
                'max:500',
                'string',
            ],
            'project.date' => [
                'date', // enviar el dato así https://www.w3schools.com/php/func_date_strtotime.asp
            ],
            'project.cycles' => [
                'json',
            ],
            'project.lead_time' => [
                'integer',
            ],
            'project.delivery_date' => [
                'date',
            ],
            'project.start_date' => [
                'date',
            ],
            'project.end_date' => [
                'date',
            ],
            'project.description' => [
                'min:5',
                'max:1000',
            ],
            'project.diagnosis' => [
                'min:5',
                'max:300',
            ],
            'project.justification' => [
                'string',
            ],
            'project.direct_beneficiaries' => [
                'json',
            ],
            'project.indirect_beneficiaries' => [
                'json',
            ],
            'project.strategies' => [
                'json',
            ],
            'project.bibliografies' => [
                'json',
            ],
            'project.observations' => [
                'json',
            ],
            'project.send_quipux' => [
                'json',
            ],
            'project.receive_quipux' => [
                'json',
            ],
            'location.id' => [
                'required',
                'integer',
            ],
            'entity.id' => [
                'integer',
            ],
            'school_period.id' => [
                'integer',
            ],
            'career.id' => [
                'integer',
            ],
            'coverage.id' => [
                'integer',
            ],
            'location.id' => [
                'integer',
            ],
            'frequency.id' => [
                'integer',
            ],
            'status.id' => [
                'integer',
            ],
            'createdBy.id' => [
                'integer',
            ],
        ];
        return CommunityFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'project.code' => 'codigo',
            'project.title' => 'titulo',
            'project.date' => 'fecha',
            'project.cycles' => 'ciclos',
            'project.lead_time' => 'plazo_tiempo',
            'project.delivery_date' => 'fecha_entrega',
            'project.start_date' => 'fecha_inicio',
            'project.end_date' => 'fecha_final',
            'project.description' => 'descripcion',
            'project.diagnosis' => 'diagnostico',
            'project.justification' => 'justificacion',
            'project.direct_beneficiaries' => 'beneficiarios_directos',
            'project.indirect_beneficiaries' => 'beneficiarios_indirectos',
            'project.strategies' => 'estrategias',
            'project.bibliografies' => 'bibliografias',
            'project.observations' => 'observaciones',
            'project.send_quipux' => 'envio_quipux',
            'project.receive_quipux' => 'recibido_quipux',
            'entity.id' => 'entidad-id',
            'school_period.id' => 'periodo-escolar-id',
            'career.id' => 'carrera-id',
            'coverage.id' => 'cobertura-id',
            'location.id' => 'locacion-id',
            'frequency.id' => 'frecuencia-id',
            'status.id' => 'estado-id',
            'created_by.id' => 'creado-por-id',
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}