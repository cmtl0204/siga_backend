
<?php

namespace App\Http\Requests\Uic\Modality;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Uic\UicFormRequest;

class IndexModalityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return UicFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [];
        return UicFormRequest::attributes($attributes);
    }
}