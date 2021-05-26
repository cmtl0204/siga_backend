<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Course\IndexCourseRequest;
use Illuminate\Http\Request;

//Models 
use App\Models\Cecy\Course;

//FormRequest



class CourseController extends Controller
{
    function index(IndexCourseRequest $request)
    {
        $courses = Course::paginate($request->input('per_page'));
        if (!$courses) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

     
        if ($courses->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Cursos',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($courses, 200);
    }


    public function storeCourse(IndexCourseRequest $request)
    {
       return 'esto es store';
    }


}
