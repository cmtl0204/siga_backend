<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Event\DeleteEventRequest;
use App\Http\Requests\Uic\Event\IndexEventRequest;
use App\Http\Requests\Uic\Event\StoreEventRequest;
use App\Http\Requests\Uic\Event\UpdateEventRequest;
use App\Models\App\Catalogue;
use App\Models\Uic\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class EventController extends Controller
{
    public function index(IndexEventRequest $request)
    {
        if ($request->has('per_page')) {
            $events = Catalogue::where('type', 'CONVOCATORY_EVENT')->paginate($request->input('per_page'));
        } else {
            $events = Catalogue::where('type', 'CONVOCATORY_EVENT')->get();
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

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $dataCatalogue = $data['event'];

        $catalogue = new Catalogue();
        $catalogue->name = $dataCatalogue['name'];
        $catalogue->code = $dataCatalogue['name'];
        $catalogue->type = 'CONVOCATORY_EVENT';
        $catalogue->save();

        return response()->json([
            'data' =>  $catalogue,
            'msg' => [
                'summary' => 'Evento creado',
                'detail' => 'El evento fue creado',
                'code' => '201'
            ]
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $event = Catalogue::find($id);
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
        $data = $request->json()->all();
        $dataCatalogue = $data['event'];
        $event->name = $dataCatalogue['name'];
        $event->code = $dataCatalogue['name'];
        $event->type = 'CONVOCATORY_EVENT';

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
    function delete(DeleteEventRequest $request)
    {
        // Es una eliminación lógica
        Catalogue::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'evento(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
