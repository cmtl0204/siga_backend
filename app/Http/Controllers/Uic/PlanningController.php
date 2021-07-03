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
        $hoy = Carbon::today();
        $hoy->format('Y-m-d h:m:s');

        if ($request->has('search')) {

            $plannings = Planning::name($request->input('search'))
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $plannings = Planning::where('end_date', '>=', $hoy)->paginate($request->input('per_page')); //Where date se encarga de hacer la comparación entre  fechas
        }

        if ($plannings->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron planificaciones',
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
                    'summary' => 'La planificacion no existe',
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
        $planning = new Planning;
        if ($request->input('planning.start_date') <= $request->input('planning.end_date')) {
            $planning->name = $request->input('planning.name');
            $planning->number = $request->input('planning.number');
            $planning->start_date = $request->input('planning.start_date');
            $planning->end_date = $request->input('planning.end_date');
            $planning->description = $request->input('planning.description');
            $planning->save();
            return response()->json([
                'data' => $planning->fresh(), //revisar el fresh -> id
                'msg' => [
                    'summary' => 'Planificacion creada',
                    'detail' => 'La planificacion fue creado',
                    'code' => '201'
                ]
            ], 201);
        }
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'La fecha final debe ser mayor a la fecha de inicio',
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
                    'summary' => 'La planificacion no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        $planning->name = $request->input('planning.name');
        $planning->number = $request->input('planning.number');
        $planning->start_date = $request->input('planning.start_date');
        $planning->end_date = $request->input('planning.end_date');
        $planning->description = $request->input('planning.description');
        $planning->save();
        return response()->json([
            'data' => $planning->fresh(),
            'msg' => [
                'summary' => 'PLanificación actualizada',
                'detail' => 'La planificacion fue actualizado',
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
                'summary' => 'Planificacion(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
