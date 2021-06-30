<?php

namespace App\Http\Requests\Cecy\Planification;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ShowByIdPlanificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [

          
            'planification.date_start' => [
                'required'
            ],
            'planification.date_end' => [
                'required'
            ],
            'planification.course.id' => [
                'required'
            ],
            'planification.needs' => [
                'required'
            ], 'planification.user.id' => [
                'required'
            ],
            'planification.status.id' => [
                'required'
            ],
        
        ];
        return CecyFormRequest::rules($rules);

    }


    public function attributes(){
        
        $attributes = [
                   
        ];

        return CecyFormRequest::rules($attributes);
    } 
}
