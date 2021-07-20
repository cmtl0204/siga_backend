<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Planning\DeletePlanningRequest;
use App\Http\Requests\Uic\Planning\IndexPlanningRequest;
use App\Http\Requests\Uic\Planning\StorePlanningRequest;
use App\Http\Requests\Uic\Planning\UpdatePlanningRequest;
use App\Models\Uic\Planning;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class PlanningController extends Controller
{
    public function index(IndexPlanningRequest $request)
    {
        if ($request->has('search')) {
            $plannings = Planning::date()->name($request->input('search'))
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $plannings = Planning::date()->paginate($request->input('per_page'));
        }

        if ($plannings->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron convocatorias',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($plannings, 200);
    }

    public function show(Planning $planning) //cambiar
    {
        if (!$planning) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La convocatoria no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $planning,
            'msg' => [
                'summary' => '',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function store(StorePlanningRequest $request)
    {
        $date = Carbon::now();
        $date = $date->toDateString();

        if ($request->input('planning.end_date') >= $date) {
            $planning = new Planning;
            $planning->career_id = $request->input('planning.career.id');
            $planning->name = $request->input('planning.name');
            $planning->start_date = $request->input('planning.start_date');
            $planning->end_date = $request->input('planning.end_date');
            $planning->description = $request->input('planning.description');
            $planning->save();
            return response()->json([
                'data' => $planning->fresh(), //revisar el fresh -> id
                'msg' => [
                    'summary' => 'Convocatoria creada',
                    'detail' => 'La planificacion fue creado',
                    'code' => '201'
                ]
            ], 201);
        }

        return response()->json([
            'data' => '',
            'msg' => [
                'summary' => 'La fecha fin debe ser mayor a la fecha actual',
                'detail' => 'Intente otra vez',
                'code' => '404'
            ]
        ], 404);
    }

    public function update(UpdatePlanningRequest $request, Planning $planning)
    {
        if (!$planning) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La convocatoria no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        $planning->career_id = $request->input('planning.career.id');
        $planning->name = $request->input('planning.name');
        $planning->start_date = $request->input('planning.start_date');
        $planning->end_date = $request->input('planning.end_date');
        $planning->description = $request->input('planning.description');
        $planning->save();
        return response()->json([
            'data' => $planning->fresh(),
            'msg' => [
                'summary' => 'Convocatoria actualizada',
                'detail' => 'La convocatoria fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }
    function delete(DeletePlanningRequest $request)
    {
        // Es una eliminación lógica
        Planning::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Convocatorias eliminados',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
