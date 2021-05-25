<?php

namespace App\Http\Controllers\Requests\Cecy\Course;

use Illuminate\Foundation\Http\FormRequest;

class IndexCourseRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        
           $rules = [
            'course.name'=>[
                'required',
                'min:10',
                'max:1000'
            ],
               
        ]; 
        
        return IndexCourseRequest::rules($rules);
    }

    public function attributes(){}

   
}
