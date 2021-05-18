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
use Illuminate\Support\Facades\Request;

class CourseController extends Controller
{

    // function  test(Request $request)
    // {
    //     return Professional::select('about_me', 'has_travel')->with('academicFormations')->get();
    // }
    // Devuelve un array de objetos y paginados
    function index(IndexCourseRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder consultar en el modelo course.
        $professional = Professional::getInstance($request->input('professional_id'));
        if ($request->has('search')) {
            $courses = $professional->courses()
                ->description($request->input('search'))
                ->name($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $courses = $professional->courses()->paginate($request->input('per_page'));
        }

        if (sizeof($courses) === 0) {
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
        //$course = $course->with('type')->first();
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
    function store(CreateCourseRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo course.
        $professional = Professional::getInstance($request->input('professional.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo course.
        $type = Catalogue::getInstance($request->input('type.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo course.
        $institution = Catalogue::getInstance($request->input('institution.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo course.
        $certificationType = Catalogue::getInstance($request->input('certificationType.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo course.
        $area = Catalogue::getInstance($request->input('area.id'));

        $course = new Course();
        $course->name = $request->input('course.name');
        $course->description = $request->input('course.description');
        $course->start_date = $request->input('course.start_date');
        $course->end_date = $request->input('course.end_date');
        $course->hours = $request->input('course.hours');
        $course->professional()->associate($professional);
        $course->institution()->associate($institution);
        $course->type()->associate($type);
        $course->certificationType()->associate($certificationType);
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
    function update(UpdateCourseRequest $request, $courseId)
    {
        $type = Catalogue::getInstance($request->input('type.id'));
        $institution = Catalogue::getInstance($request->input('institution.id'));
        $certificationType = Catalogue::getInstance($request->input('certificationType.id'));
        $area = Catalogue::getInstance($request->input('area.id'));

        $course = Course::find($courseId);

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
        $course->certificationType()->associate($certificationType);
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
    function destroy(Course $course)
    {
        // Es una eliminación lógica
        $course->delete();
        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'Habilidad eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]
        ], 201);
    }
}