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
          
        ];

        return IndexCourseRequest::rules($rules);
    }

    public function attributes(){
        
    }

   
}
