<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models 
use App\Models\Cecy\Course;

//FormRequest
use App\Http\Controllers\Requests\Cecy\Course\IndexCourseRequest;


class CourseController extends Controller
{
    function index (IndexCourseRequest $request)
    {
    
        return $request;
    }
    
}
