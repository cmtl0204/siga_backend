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

          
            'course.status' => [
                'required'
            ],
            'course.approval_date' => [
                'required'
            ],


        ];

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
            'course.status' => 'status',
            'course.approval_date' =>'approval_date',

            
        ];

        return CecyFormRequest::rules($attributes);
    }   
}
