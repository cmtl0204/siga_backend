<?php

namespace App\Http\Requests\Community\ProjectParticipant;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Community\CommunityFormRequest;

class IndexProjectParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
        ];
        return CommunityFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
        ];
        return CommunityFormRequest::attributes($attributes);
    }
}