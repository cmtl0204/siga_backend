<?php

namespace App\Http\Requests\Community\Assignment;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'assignment.date_request' => [
                'date',
            ],
            'assignment.status' => [
                'min:5',
                'string',
            ],
            'assignment.observation' => [
                'min:10',
                'min:500',
                'string',
            ],
            
            'assignment.level' => [
                'min:1',
                'string',
            ],
            'user.id' => [
                'required',
                'integer',
            ],
            'career.id' => [
                'required',
                'integer',
            ],
        ];
        return CommunityFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'assignment.date_request' => 'date_request',
            'assignment.status' => 'status',
            'assignment.observation' => 'observation',
            'assignment.level' => 'level',
            'user.id' => 'user-id',
            'career.id' => 'career-id',
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}