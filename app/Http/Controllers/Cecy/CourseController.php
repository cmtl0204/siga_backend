<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Course\ApprovalCourseRequest;
use App\Http\Requests\Cecy\Course\IndexCourseRequest;
use App\Http\Requests\Cecy\Course\CourseAprovalCourseRequest;
use App\Http\Requests\Cecy\Course\CourseShowByIdCourseRequest;
use App\Http\Requests\Cecy\Course\DeleteCourseRequest;
use App\Http\Requests\Cecy\Course\TutorAsisignmentRequest;
use App\Models\App\Status;
use App\Models\Authentication\User;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Institutions;

use Illuminate\Http\Request;

//Models
use App\Models\Cecy\Course;
use App\Models\Cecy\Planification;
use App\Models\App\Catalogue;
use App\Models\App\Classroom;
use App\Models\App\Career;


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
        $courses = Course::with('status', 'career', 'planification')->paginate($request->input('per_page'));
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
    //funcion store para crear un nuevo curso se llama al nombre del curso, numero de horas y el docente
    //se llaman a todos los ids de la tabla cursos para que no de ningun errror
    //para que llame al estado se le cambio a id y lo llama desde la tabla app Status
    public function storeCourse(Request $request)
    {
        $course = new Course();
        $course->name = $request->input('course.name');
        $course->hours_duration = $request->input('course.hours_duration');
        $course->code = $request->input('course.code');
        $area = Catalogue::getInstance($request->input('course.area.id'));
        $course->area()->associate($area);
        $level = Catalogue::getInstance($request->input('course.level.id'));
        $course->level()->associate($level);
        $cantonDictate = Catalogue::getInstance($request->input('course.canton_dictate.id'));
        $course->cantonDictate()->associate($cantonDictate);
        $capacitationType = Catalogue::getInstance($request->input('course.capacitation_type.id'));
        $course->capacitationType()->associate($capacitationType);
        $courseType = Catalogue::getInstance($request->input('course.course_type.id'));
        $course->courseType()->associate($courseType);
        $entityCertificationType = Catalogue::getInstance($request->input('course.entity_certification_type.id'));
        $course->entityCertificationType()->associate($entityCertificationType);
        $personProposal = User::getInstance($request->input('course.person_proposal.id'));
        $course->personProposal()->associate($personProposal);
        $classroom = Classroom::getInstance($request->input('course.classroom.id'));
        $course->classroom()->associate($classroom);
        $specialty = Catalogue::getInstance($request->input('course.specialty.id'));
        $course->specialty()->associate($specialty);
        $academicPeriod = Catalogue::getInstance($request->input('course.academic_period.id'));
        $course->academicPeriod()->associate($academicPeriod);
        $institution = Institutions::getInstance($request->input('course.institution.id'));
        $course->institution()->associate($institution);
        $course->setec_name = $request->input('course.setec_name');
        $course->abbreviation = $request->input('course.abbreviation');
        $certifiedType = Catalogue::getInstance($request->input('course.certified_type.id'));
        $course->certifiedType()->associate($certifiedType);
        $career = Career::getInstance($request->input('course.career.id'));
        $course->career()->associate($career);
        $status = Status::getInstance($request->input('course.status.id'));
        $course->status()->associate($status);
        $course->save();
        return response()->json([
            'msg' => [
                'summary' => 'Curso creado con exito.',
                'detail' => '',
                'code' => '201',
                'icon' =>  'success'


            ]
        ], 201);
    }
    //Funcion para aprobar el curso 
    function  approvalCourse(ApprovalCourseRequest $request, Course $course)
    {

        $status = Status::getInstance($request->input('course.status.id'));
        $course->status()->associate($status);
        $course->name = $request->input('course.name');
        $course->approval_date = date("Y-m-d H:i:s");
        $course->save();

        return response()->json([
            'msg' => [
                'summary' => 'Curso actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function UpdateCodeCourse(Request $request)
    {
        if ($request->has(['course.id', 'course.code', 'course.name', 'course.hours_duration', 'course.setec_name'])) {
            $course = Course::find($request->input('course.id'));
            $course->code = $request->input('course.code');
            $course->name = $request->input('course.name');
            $course->hours_duration = $request->input('course.hours_duration');
            $course->setec_name = $request->input('course.setec_name');

            $course->save();
            return response()->json([
                'msg' => [
                    'summary' => 'curso actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ], 201);
        }

        return response()->json([
            'msg' => [
                'summary' => 'informacion no valida',
                'detail' => 'id o el codigo del curso no son validos',
                'code' => '400'
            ]
        ], 400);
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

        $course = Course::where('id', $courseId)->with('status')->get();


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
            ]
        ], 200);
    }

    //Retorna todos los usuarios 
    function getResponsables()
    {

        $responsables = User::all();

        return response()->json([
            'data' => $responsables->fresh(),
            'msg' => [
                'summary' => 'Curso actualizado',
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


        $course = Planification::select('course_id', 'user_id')->where('user_id', $request->input('responsable.id'))->with('user')->get();


        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'Responsable asignado',
                'detail' => 'El responsable fue asignado',
                'code' => '201'
            ]
        ], 201);
    }
    function delete(DeleteCourseRequest $request)
    {
        Course::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Curso(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
