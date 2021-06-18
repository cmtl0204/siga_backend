<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cecy\DetailPlanification;


class DetailPlanificationController extends Controller
{
    public function index(IndexDetailsPlanificarioneRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
    $course = Course ::getInstance($request->input('course_id'));
    $status = Status ::getInstance($request->input('state_id'));

    if ($request->has('search')) {
        $detailPlanifications = $course->detailPlanifications()
            
            ->paginate($request->input('per_page'));
    } else {
        $detailPlanifications = $course->detailPlanifications()->paginate($request->input('per_page'));
    }

    if ($detailPlanifications->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron detalles',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($prerequisites, 200);
        
    }

    public function show( DetailPlanification $detailPlanification)
    {
        {

            return response()->json([
                'data' => $detailPlanifications,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        } 
    }

    public function store(StoreDetailsPlanificationRequest $request)
    {
        $data = $request -> json() -> all();
        $state = $data ['detailPlanifications'] ['state'];
    
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        //$course = Course::getInstance($request->input('course.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        //$type = Catalogue::getInstance($request->input('type.id'));


        $prerequisite = new DetailPlanification();
        $detailPlanification -> course_id=  $request -> input('detailplanifications.course.id')
        $detailPlanification -> instructor_id=  $request -> input('detailplanifications.instructor.id')
        $detailPlanification -> authority_rector()-> (Authorities::findOrFail())

       

        return response()->json([
            'data' => $detailPlanifications,
            'msg' => [
                'summary' => ' creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    
}
