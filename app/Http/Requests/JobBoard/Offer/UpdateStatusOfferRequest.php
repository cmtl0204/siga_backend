<?php

namespace App\Http\Requests\JobBoard\Offer;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'offer.status.id' => [
                'required',
                'integer',
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'offer.status.id' => 'estado-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
