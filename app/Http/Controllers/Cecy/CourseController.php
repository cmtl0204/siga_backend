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


   function getResponsables(){

        $responsables = DB::table('cecy.authorities')
        ->join('authentication.users', 'cecy.authorities.user_id', '=','authentication.users.id')->get();

         return $responsables;
    }


    function tutorAssignment(TutorAsisignmentRequest $request, Planification $planification ){

    // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $responsable = Authority::getInstance($request->input('id'));

        $responsable->responsable()->associate($responsable);
        $responsable->save();

        return response()->json([
            'data' => $responsable->fresh(),
            'msg' => [
                'summary' => 'Habilidad actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
            
        

    }





}
