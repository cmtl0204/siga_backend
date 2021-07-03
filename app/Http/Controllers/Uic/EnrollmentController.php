<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Enrollment\DeleteEnrollmentRequest;
use App\Http\Requests\Uic\Enrollment\IndexEnrollmentRequest;
use App\Http\Requests\Uic\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\Uic\Enrollment\UpdateEnrollmentRequest;
use App\Models\Uic\Enrollment;
// Models

// FormRequest en el index store update

class EnrollmentController extends Controller
{
    public function index(IndexEnrollmentRequest $request)
    {

        if ($request->has('search')) {
            $enrollments = Enrollment::date($request->input('search'))->code($request->input('search'))
            ->paginate($request->input('per_page'));
        } else {
            $enrollments = Enrollment::paginate($request->input('per_page'));
        }

        if($enrollments->count()===0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron inscripciones',
                    'detail'=>'Intentelo de nuevo',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json($enrollments,200);
    }

    public function show(Enrollment $enrollment)
    {
        if(!$enrollment){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La inscripción no existe',
                    'detail'=>'Intente con otra inscripción',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json([
            'data'=>$enrollment,
            'msg'=>[
                'summary'=>'La inscripción no existe',
                'detail'=>'Intente con otra inscripción',
                'code'=>'404'
            ]
        ],200);
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $enrollment = new Enrollment;
        $enrollment->modality_id=$request->input('enrollment.modality_id');
        $enrollment->school_period_id=$request->input('enrollment.school_period_id');
        $enrollment->planning_id=$request->input('enrollment.planning_id');
        $enrollment->mesh_student_id=$request->input('enrollment.mesh_student_id');
        $enrollment->date=$request->input('enrollment.date');
        $enrollment->code=$request->input('enrollment.code');
        $enrollment->status_id=$request->input('enrollment.status_id');
        $enrollment->observations=$request->input('enrollment.observations');
        $enrollment->save();
        return response()->json([
            'data'=>$enrollment,
            'msg'=>[
                'summary'=>'Inscripción creada',
                'detail'=>'El registro fue creado',
                'code'=>'201'
            ]
        ],201);
    }

    public function update(UpdateEnrollmentRequest $request, $id)
    {
        $enrollment = Enrollment::find($id);
        if(!$enrollment){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La inscripción no existe',
                    'detail'=>'Intente con otra inscripción',
                    'code'=>'404'
                ]
            ],400);
        }
        $enrollment->modality_id=$request->input('enrollment.modality_id');
        $enrollment->school_period_id=$request->input('enrollment.school_period_id');
        $enrollment->planning_id=$request->input('enrollment.planning_id');
        $enrollment->mesh_student_id=$request->input('enrollment.mesh_student_id');
        $enrollment->date=$request->input('enrollment.date');
        $enrollment->code=$request->input('enrollment.code');
        $enrollment->status_id=$request->input('enrollment.status_id');
        $enrollment->observations=$request->input('enrollment.observations');
        $enrollment->save();
        return response()->json([
            'data'=>$enrollment->fresh(),
            'msg'=>[
                'summary'=>'Inscripción actualizada',
                'detail'=>'La inscripción fue actualizado',
                'code'=>'201'
            ]
        ],201);
    }
    function delete(DeleteEnrollmentRequest $request)
    {
        // Es una eliminación lógica
        Enrollment::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Inscripción(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
}
