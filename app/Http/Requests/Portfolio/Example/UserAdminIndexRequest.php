<?php

namespace App\Http\Requests\Authentication\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Portfolio\PortfolioFormRequest;

class UserAdminIndexRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function attributes()
    {
        $attributes = [];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
