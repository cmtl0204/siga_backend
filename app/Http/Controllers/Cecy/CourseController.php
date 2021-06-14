<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Course\IndexCourseRequest;
use App\Http\Requests\Cecy\Course\CourseAprovalCourseRequest;
use App\Models\App\Status;
use App\Models\Authentication\User;
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
                    'summary' => 'No se encontraró curso',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }


        if ($courses->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Cursos',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        return response()->json($courses, 200);
    }

    function  approvalCourse(CourseAprovalCourseRequest $request, Course $course)
    {

        $course->status = $request->input('course.status');
        $course->approval_date = $request->input('course.approval_date');
        $course->save();

        return response()->json([
            'data' => $course->fresh(),
            'msg' => [
                'summary' => 'Curso actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }


   function tutorAssignment(){

        $tutors = User::all();
        
        

    }



}
