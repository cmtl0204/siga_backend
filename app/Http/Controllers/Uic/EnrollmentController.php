<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Models\Uic\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
// Models

// FormRequest en el index store update

class EnrollmentController extends Controller
{
    public function index():JsonResponse
    {
        $enrollments = Enrollment::all();
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
        return response()->json([
            'data'=>$enrollments,
        ],200);
    }

    public function show($enrollmentId)
    {
        $enrollment = Enrollment::find($enrollmentId);
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
            'data'=>$enrollment
        ],200);
    }

    public function store(Request $request)
    {
        $enrollment = new Enrollment;
        $enrollment->modality_id=$request->input('modality_id');
        $enrollment->school_period_id=$request->input('school_period_id');
        $enrollment->date=$request->input('date');
        $enrollment->code=$request->input('code');
        $enrollment->status_id=$request->input('status_id');
        $enrollment->observations=$request->input('observations');
        $enrollment->save();
        return response()->json([
            'data'=>$enrollment->fresh(),
            'msg'=>[
                'summary'=>'Inscripción creada',
                'detail'=>'El registro fue creado',
                'code'=>'201'
            ]
        ],201);
    }

    public function update(Request $request, $id)
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
        $enrollment->modality_id=$request->input('modality_id');
        $enrollment->school_period_id=$request->input('school_period_id');
        $enrollment->date=$request->input('date');
        $enrollment->code=$request->input('code');
        $enrollment->status_id=$request->input('status_id');
        $enrollment->observations=$request->input('observations');
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

    public function destroy($enrollment)
    {
        $enrollment = Enrollment::find($enrollment);

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
        $enrollment->delete();
        return response()->json([
            'data'=>null,
            'msg'=>[
                'summary'=>'Inscripción eliminada',
                'detail'=>'La inscripción fue eliminada',
                'code'=>'201'
            ]
        ],201);

    }
}
