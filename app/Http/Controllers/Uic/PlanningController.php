<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Planning\DeletePlanningRequest;
use App\Http\Requests\Uic\Planning\IndexPlanningRequest;
use App\Http\Requests\Uic\Planning\StorePlanningRequest;
use App\Http\Requests\Uic\Planning\UpdatePlanningRequest;
use App\Models\Uic\Planning;
// Models

// FormRequest en el index store update

class PlanningController extends Controller
{
    public function index(IndexPlanningRequest $request)
        {
        $plannings = Planning::paginate($request->input('per_page'));
        if($plannings->count()===0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron planificaciones',
                    'detail'=>'Intentelo de nuevo',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json($plannings,200);
    }

    public function show($planningId)
    {
        $planning = Planning::find($planningId);
        if(!$planning){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La planificacion no existe',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json([
            'data'=>$planning
        ],200);
    }

    public function store(StorePlanningRequest $request)
    {
        $planning = new Planning;
        $planning->name=$request->input('planning.name');
        $planning->number=$request->input('planning.number');
        $planning->event=$request->input('planning.event');
        $planning->start_date=$request->input('planning.start_date');
        $planning->end_date=$request->input('planning.end_date');
        $planning->description=$request->input('planning.description');
        $planning->save();
        return response()->json([
            'data'=>$planning->fresh(),
            'msg'=>[
                'summary'=>'Planificacion creada',
                'detail'=>'La planificacion fue creado',
                'code'=>'201'
            ]
        ],201);
    }

    public function update(UpdatePlanningRequest $request, $id)
    {
        $planning = Planning::find($id);
        if(!$planning){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La planificacion no existe',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],400);
        }
        $planning->name=$request->input('planning.name');
        $planning->number=$request->input('planning.number');
        $planning->event=$request->input('planning.event');
        $planning->start_date=$request->input('planning.start_date');
        $planning->end_date=$request->input('planning.end_date');
        $planning->description=$request->input('planning.description');
        $planning->save();
        return response()->json([
            'data'=>$planning->fresh(),
            'msg'=>[
                'summary'=>'PLanificación actualizada',
                'detail'=>'La planificacion fue actualizado',
                'code'=>'201'
            ]
        ],201);
    }
    function delete(DeletePlanningRequest $request)
    {
        // Es una eliminación lógica
        Planning::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Planificacion(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
}
