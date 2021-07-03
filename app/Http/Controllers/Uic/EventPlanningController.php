<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\EventPlanning\DeleteEventPlanningRequest;
use App\Http\Requests\Uic\EventPlanning\IndexEventPlanningRequest;
use App\Http\Requests\Uic\EventPlanning\StoreEventPlanningRequest;
use App\Http\Requests\Uic\EventPlanning\UpdateEventPlanningRequest;
use App\Models\Uic\EventPlanning;

use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Models\Uic\Event;
use App\Models\Uic\Planning;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class EventPlanningController extends Controller
{
    public function index(IndexEventPlanningRequest $request)
    {
        $hoy = Carbon::today();
        $hoy->format('Y-m-d h:m:s');

        if ($request->has('search')) {
        } else {
            $eventplannings = EventPlanning::paginate($request->input('per_page')); //Where date se encarga de hacer la comparación entre  fechas
        }

        if ($eventplannings->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Eventos asignados',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($eventplannings, 200);
    }

    public function show(EventPlanning $eventplanning)
    {
        if (!$eventplanning) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La asignación no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $eventplanning,
            'msg' => [
                'summary' => 'La asignación no existe',
                'detail' => 'Intente otra vez',
                'code' => '404'
            ]
        ], 200);
    }

    public function store(StoreEventPlanningRequest $request)
    {
        $eventplanning = new EventPlanning;
        if ($request->input('eventPlanning.start_date') <= $request->input('eventPlanning.end_date')) {
            $eventplanning->planning_id = $request->input('eventPlanning.planning.id');
            $eventplanning->event_id = $request->input('eventPlanning.event.id');
            $eventplanning->start_date = $request->input('eventPlanning.start_date');
            $eventplanning->end_date = $request->input('eventPlanning.end_date');
            $eventplanning->observations = $request->input('eventPlanning.observations');
            $eventplanning->save();
            return response()->json([
                'data' => $eventplanning,
                'msg' => [
                    'summary' => 'Asignación creada',
                    'detail' => 'La asignación fue creada',
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

    public function update(UpdateEventPlanningRequest $request, $id)
    {
        $eventplanning = EventPlanning::find($id);
        if (!$eventplanning) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La planificacion no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        if ($request->input('eventPlanning.start_date') <= $request->input('eventPlanning.end_date')) {
            $eventplanning->planning_id = $request->input('eventPlanning.planning.id');
            $eventplanning->event_id = $request->input('eventPlanning.event.id');
            $eventplanning->start_date = $request->input('eventPlanning.start_date');
            $eventplanning->end_date = $request->input('eventPlanning.end_date');
            $eventplanning->observations = $request->input('eventPlanning.observations');
            $eventplanning->save();
            return response()->json([
                'data' => $eventplanning,
                'msg' => [
                    'summary' => 'Asignación actualizada',
                    'detail' => 'La asignación fue actualizada',
                    'code' => '201'
                ]
            ], 201);
        }
    }
    function delete(DeleteEventPlanningRequest $request)
    {
        // Es una eliminación lógica
        EventPlanning::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Asignación(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
    function uploadFile(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, EventPlanning::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, EventPlanning::getInstance($request->input('id')));
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, EventPlanning::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
