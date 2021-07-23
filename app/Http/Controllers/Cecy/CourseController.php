<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Course\ApprovalCourseRequest;
use App\Http\Requests\Cecy\Course\IndexCourseRequest;
use App\Http\Requests\Cecy\Course\CourseAprovalCourseRequest;
use App\Http\Requests\Cecy\Course\CourseShowByIdCourseRequest;
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
    //Funcion para retornar todos los cursos
    function index(IndexCourseRequest $request)
    {
        $courses = Course::where( 'status_id' ,47 )->get();
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


  

        return response()->json([
            'data' => $courses,
            'msg' => [
                'summary' => 'aqui estan todos los curos',
                'detail' => 'todo ok',
                'code' => '200'
            ]
        ], 200);
    }

    //Traer todos los cursos con sus relaciones

    function allCourseWithRelations(IndexCourseRequest $request)
    {
        $courses = Course::with('status','career')->orderBy('created_at', 'ASC')->paginate($request->input('per_page'));
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


  

        return response()->json($courses, 200);
    }

    //Funcion para aprobar el curso 
    function  approvalCourse(ApprovalCourseRequest $request, Course $course)
    {

        $status = Status::getInstance($request->input('course.status.id'));

        $course->status()->associate($status);
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

    


    

    //Funciom para traer cursos por id
   //Modificar una planificaion 
   function  showByIdCourse($ID)
   {
    
    $planification = Course::where( 'id' ,$ID)->with('status')->get();
        if(sizeof($planification)  === 0){

            return response()->json([
                'data' => $planification,
                'msg' => [
                    'summary' => 'No existe esa planificacion',
                    'detail' => 'No exixste',
                    'code' => '201'
                ]
            ], 201);
        }
       return response()->json([
           'data' => $planification,
           'msg' => [
               'summary' => 'Planificacion actualizada',
               'detail' => 'La planificacion fue actualizada exitosamente',
               'code' => '201'
           ]
       ], 201);
   }

    //Retorna todos los usuarios 
    function getResponsables()
    {

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
 



    function tutorAssignment(Planification $planification, TutorAsisignmentRequest $request)
    {

        $user = User::getInstance($request->input('responsable.id'));

        $planification->user()->associate($user);
        $planification->save();


        $course = Planification::select('course_id','user_id')->where( 'user_id' ,$request->input('responsable.id'))->with('user')->get();


        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'Responsable asignado',
                'detail' => 'El responsable fue asignado',
                'code' => '201'
            ]
        ], 201);
    }
}
