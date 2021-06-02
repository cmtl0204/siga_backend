<?php

namespace App\Http\Requests\Cecy\Course;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;


class CourseAprovalCourseRequest extends FormRequest
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

            'id' => [
                'required',
            ],
            'status' => [
                'required'
            ],
            'approval_date' => [
                'required'
            ],


        ];

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
            'id' => 'id_curso',
            'status' => 'estado',
            'approval_date' =>'fecha de aprobacion',

            
        ];

        return CecyFormRequest::rules($attributes);
    }   
}
