<?php

namespace App\Http\Requests\Cecy\Course;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class TutorAsisignmentRequest extends FormRequest
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

          
            'responsable.id' => [
                'required'
            ],
        


        ];

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
            'responsable.id' => 'responsable_id',
                   
        ];

        return CecyFormRequest::rules($attributes);
    }   

    
}
