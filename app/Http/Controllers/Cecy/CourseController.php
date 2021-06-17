<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Course\IndexCourseRequest;
use App\Http\Requests\Cecy\Course\CourseAprovalCourseRequest;
use App\Http\Requests\Cecy\Course\TutorAsisignmentRequest;
use App\Models\App\Status;
use App\Models\Authentication\User;
use App\Models\Cecy\Authority;
use Illuminate\Http\Request;

//Models
use App\Models\Cecy\Course;
use App\Models\Cecy\Planification;
use DateTime;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

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

    //Funcion para aprobar el curso 
    function  approvalCourse(CourseAprovalCourseRequest $request, Course $course)
    {

        $course->status = $request->input('course.status');
        $course->approval_date = date("Y-m-d H:i:s");
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

    //Funcion para listar planificacion 


//Retorna todos los usuarios 
   function getResponsables(){

        $responsables = User::all();

        return response()->json([
            'data' => $responsables->fresh(),
            'msg' => [
                'summary' => 'Curso actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }


   
    //Funcion para traer planificaciones
   function getPlanifiation(){

    $planifications =  Planification::with('course')->get();

    return response()->json([
        'data' => $planifications,
        'msg' => [
            'summary' => 'REgistros ',
            'detail' => 'El registro devueltos',
            'code' => '201'
        ]
    ], 201);
}



    function tutorAssignment(Planification $planification, TutorAsisignmentRequest $request){

       $user = User::getInstance($request->input('responsable.id'));

       $planification->teacherResponsable()->associate($user);
       $planification->save();

       return response()->json([
           'data' => $planification->fresh(),
           'msg' => [
               'summary' => 'Responsable asignado',
               'detail' => 'El responsable fue asignado',
               'code' => '201'
           ]], 201);

    }





}
