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
        $courses = Course::with('name')->paginate($request->input('per_page'));
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
    function getCourse($courseId)
    {
        if (!is_numeric($courseId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]
            ], 400);
        }
        
        $course = Course::where( 'id' ,$courseId)->with('status')->get();
        
        
        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$course) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Curso no encontrado',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]
            ], 404);
        }


        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]], 200);
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
