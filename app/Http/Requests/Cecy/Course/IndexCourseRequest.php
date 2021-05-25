<?php

namespace App\Http\Controllers\Requests\Cecy\Course;

use App\Http\Requests\Cecy\CecyFormRequest;
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

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
          
        ];

        return CecyFormRequest::rules($attributes);
    }   

   
}
