<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\CatalogueEvent\DeleteCatalogueEventRequest;
use App\Http\Requests\Uic\CatalogueEvent\IndexCatalogueEventRequest;
use App\Http\Requests\Uic\CatalogueEvent\StoreCatalogueEventRequest;
use App\Http\Requests\Uic\CatalogueEvent\UpdateCatalogueEventRequest;
use App\Models\App\Catalogue;
use App\Models\Uic\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class CatalogueEventController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->json()->all();
        $dataCatalogue = $data['catalogueEvent'];

        $catalogue = new Catalogue();
        $catalogue->name = $dataCatalogue['name'];
        $catalogue->code = $dataCatalogue['name'];
        $catalogue->type = 'UIC.EVENTS.EVENT_TYPE';
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
        $dataCatalogue = $data['catalogueEvent'];
        $event->name = $dataCatalogue['name'];
        $event->code = $dataCatalogue['name'];
        $event->type = 'UIC.EVENTS.EVENT_TYPE';

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
    function delete(DeleteCatalogueEventRequest $request)
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
