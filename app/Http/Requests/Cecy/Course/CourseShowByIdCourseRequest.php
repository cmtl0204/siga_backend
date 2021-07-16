<?php

namespace App\Http\Requests\Cecy\Course;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Cecy\CecyFormRequest;


class CourseShowByIdCourseRequest extends FormRequest
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

          
            'course.id' => [
                ''
            ],
       
        ];

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
            'course.id' => 'status',

            
        ];

        return CecyFormRequest::rules($attributes);
    }   
}
