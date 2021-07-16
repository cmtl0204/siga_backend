<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Event\DeleteEventRequest;
use App\Http\Requests\Uic\Event\IndexEventRequest;
use App\Http\Requests\Uic\Event\StoreEventRequest;
use App\Http\Requests\Uic\Event\UpdateEventRequest;
use App\Models\Uic\Event;
use App\Models\Uic\Planning;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class EventController extends Controller
{
    public function index(IndexEventRequest $request)
    {
        if ($request->has('search')) {
            $events = Event::date()->name($request->input('search'))
                ->planning($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $events = Event::date()->paginate($request->input('per_page')); //Where date se
        }

        if ($events->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron eventos',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($events, 200);
    }


    public function show(Event $event)
    {
        if (!$event) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El evento no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $event->fresh(),
            'msg' => [
                'summary' => 'El evento no existe',
                'detail' => 'Intente otra vez',
                'code' => '404'
            ]
        ], 200);
    }

    public function store(StoreEventRequest $request)
    {
        $event = new Event;
        $planning = Planning::findOrFail($request->input('event.planning.id'));
        if ($planning['start_date'] <= $request->input('event.start_date') && $planning['end_date'] >= $request->input('event.end_date')) {
            $event->planning_id = $request->input('event.planning.id');
            $event->name_id = $request->input('event.name.id');
            $event->start_date = $request->input('event.start_date');
            $event->end_date = $request->input('event.end_date');
            $event->save();
            return response()->json([
                'data' => $event->fresh(),
                'msg' => [
                    'summary' => 'Evento creado',
                    'detail' => 'El evento fue creado',
                    'code' => '201'
                ]
            ], 201);
        }
        return response()->json([
            'data' => '',
            'msg' => [
                'summary' => 'Las fechas deben estar dentro del rango de fechas de la Convocatoria',
                'detail' => 'Intente otra vez',
                'code' => '404'
            ]
        ], 404);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El evento no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        $planning = Planning::findOrFail($request->input('event.planning.id'));
        if ($planning['start_date'] <= $request->input('event.start_date') && $planning['end_date'] >= $request->input('event.end_date')) {
            $event->planning_id = $request->input('event.planning.id');
            $event->name_id = $request->input('event.name.id');
            $event->start_date = $request->input('event.start_date');
            $event->end_date = $request->input('event.end_date');
            $event->save();
            return response()->json([
                'data' => $event,
                'msg' => [
                    'summary' => 'Evento actualizado',
                    'detail' => 'El evento fue actualizado',
                    'code' => '201'
                ]
            ], 201);
        }
        return response()->json([
            'data' => '',
            'msg' => [
                'summary' => 'Las fechas deben estar dentro del rango de fechas de la Convocatoria',
                'detail' => 'Intente otra vez',
                'code' => '404'
            ]
        ], 404);
    }
    function delete(DeleteEventRequest $request)
    {
        // Es una eliminación lógica
        Event::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'evento(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
