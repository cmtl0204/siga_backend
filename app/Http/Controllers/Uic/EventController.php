<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Event\DeleteEventRequest;
use App\Http\Requests\Uic\Event\IndexEventRequest;
use App\Http\Requests\Uic\Event\StoreEventRequest;
use App\Http\Requests\Uic\Event\UpdateEventRequest;
use App\Models\Uic\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class EventController extends Controller
{
    public function index(IndexEventRequest $request){
        $hoy = Carbon::today();
        $hoy->format('Y-m-d h:m:s');

        if ($request->has('search')) {
           

        } else {
            $events = Event::paginate($request->input('per_page')); //Where date se 
        }

        if($events->count()===0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron eventos',
                    'detail'=>'Intentelo de nuevo',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json($events,200);
    }


    public function show($eventId)
    {
        $event = Event::find($eventId);
        if(!$event){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'El evento no existe',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json([
            'data'=>$event
        ],200);
    }

    public function store(StoreEventRequest $request)
    {
        $event = new Event;
            $event->name=$request->input('event.name');
            $event->description=$request->input('event.description');
            $event->save();
            return response()->json([
                'data'=>$event->fresh(),
                'msg'=>[
                    'summary'=>'Evento creado',
                    'detail'=>'El evento fue creado',
                    'code'=>'201'
                ]
            ],201);
  
         return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La fecha final debe ser mayor a la fecha de inicio',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],404);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::find($id);
        if(!$event){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'El evento no existe',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],400);
        }
        $event->name=$request->input('event.name');
        $event->description=$request->input('event.description');
        $event->save();
        return response()->json([
            'data'=>$event->fresh(),
            'msg'=>[
                'summary'=>'Evento actualizado',
                'detail'=>'El evento fue actualizado',
                'code'=>'201'
            ]
        ],201);
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
            ]], 201);
    }
    
}
