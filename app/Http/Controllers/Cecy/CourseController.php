<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;

use App\Http\Requests\Cecy\Course\IndexCourseRequest;

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
        $courses = Course::with('status','career')->paginate($request->input('per_page'));
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



    
 



    
}
