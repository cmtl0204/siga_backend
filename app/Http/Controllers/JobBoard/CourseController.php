<?php

namespace App\Http\Controllers\JobBoard;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\App\Catalogue;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Course;

// FormRequest
use App\Http\Requests\JobBoard\Course\IndexCourseRequest;
use App\Http\Requests\JobBoard\Course\CreateCourseRequest;
use App\Http\Requests\JobBoard\Course\UpdateCourseRequest;
use App\Http\Requests\JobBoard\Course\StoreCourseRequest;
use App\Http\Requests\JobBoard\Course\DeleteCourseRequest;

use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;

use Illuminate\Support\Facades\Request;

class CourseController extends Controller
{

    function  test(Request $request)
    {
        return Professional::select('about_me', 'has_travel')->with('academicFormations')->get();
    }
    // Devuelve un array de objetos y paginados
    function index(IndexCourseRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder consultar en el modelo course.
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        if ($request->has('search')) {
            $courses = $professional->courses()
                ->description($request->input('search'))
                ->name($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $courses = $professional->courses()->paginate($request->input('per_page'));
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

    // Devuelve un solo objeto//
    function show(Course $course)
    {
        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    //Almacena los  Datos creado del curso envia//
    function store(StoreCourseRequest $request)
    {
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo course.
        $type = Catalogue::find($request->input('course.type.id'));
        $institution = Catalogue::find($request->input('course.institution.id'));
        $certification_type = Catalogue::find($request->input('course.certification_type.id'));
        $area = Catalogue::find($request->input('course.area.id'));

        $course = new Course();
        $course->name = $request->input('course.name');
        $course->description = $request->input('course.description');
        $course->start_date = $request->input('course.start_date');
      //  $course->end_date = $this->calculateEndCourse($request->input('course.end_date'));
       
     //   $course->start_date = $request->input('course.start_date');
        $course->end_date = $request->input('course.end_date');
      
        $course->hours = $request->input('course.hours');
        $course->professional()->associate($professional);
        $course->institution()->associate($institution);
        $course->type()->associate($type);
        $course->certification_type()->associate($certification_type);
        $course->area()->associate($area);
        $course->save();

        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'Curso creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    //Actualiza los datos del curso creado//
    function update(UpdateCourseRequest $request, Course $course)
    {
        $type = Catalogue::find($request->input('course.type.id'));
        $institution = Catalogue::find($request->input('course.institution.id'));
        $certification_type = Catalogue::find($request->input('course.certification_type.id'));
        $area = Catalogue::find($request->input('course.area.id'));

        //$course = Course::find($courseId);

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

        $course->name = $request->input('course.name');
        $course->description = $request->input('course.description');
        $course->start_date = $request->input('course.start_date');
        $course->end_date = $request->input('course.end_date');
        $course->hours = $request->input('course.hours');
        $course->institution()->associate($institution);
        $course->type()->associate($type);
        $course->certification_type()->associate($certification_type);
        $course->area()->associate($area);
        $course->save();

        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'Curso actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    //Elimina los datos del curso//
    function delete(DeleteCourseRequest $request)
    {
    
           // Es una eliminación lógica
           Course::destroy($request->input('ids'));


        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Curso eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }
    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request,Course::getInstance($request->input('id')));
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Course::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
   
}


