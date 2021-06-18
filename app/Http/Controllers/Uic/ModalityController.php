<?php

namespace App\Http\Controllers\Uic;
use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Modality\DeleteModalityRequest;
use App\Http\Requests\Uic\Modality\IndexModalityRequest;
use App\Http\Requests\Uic\Modality\StoreModalityRequest;
use App\Http\Requests\Uic\Modality\UpdateModalityRequest;
use App\Models\App\Career;
use App\Models\App\Catalogue;
use App\Models\Uic\Modality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
// Models

// FormRequest en el index store update

class ModalityController extends Controller
{
    //Obtener modalidades
    public function index(IndexModalityRequest $request)
    {
        $modalities = Modality::with('enrollments')
        ->with('modalities')
        ->paginate($request->input('per_page'));
        if ($modalities->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron modalidades',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                    ]
                ], 404);
            }
            return response()->json($modalities, 200);
    }

    public function show($modalityId)
    {
        $modality = Modality::find($modalityId);
        if (!$modality) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La modalidad no existe',
                    'detail' => 'Intente con otra modalidad',
                    'code' => '404'
                ]
            ], 400);
        }
        return response()->json([
            "data" => $modality
        ], 200);
    }

    public function showModalities($modalityId)
    {
        $modality = Modality::find($modalityId);
        if (!$modality) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La modalidad no existe',
                    'detail' => 'Intente con otra modalidad',
                    'code' => '404'
                ]
            ], 400);
        }
        return response()->json([
            "data" => $modality->modalities,
        ], 200);
    }

    public function store(StoreModalityRequest $request)
    {
        $modality = new Modality;
        $modality->parent_id = $request->input('modality.parent_id');
        $modality->career_id = $request->input('modality.career_id');
        $modality->name = $request->input('modality.name');
        $modality->setDescriptionAttribute($request->input('modality.description'));
        $modality->status_id = $request->input('modality.status_id');
        $modality->save();
        return response()->json([
            'data' => $modality->fresh(),
            'msg' => [
                'summary' => 'Modalidad creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateModalityRequest $request, $modality)
    {
        $modality = Modality::find($modality);
        if (!$modality) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La modalidad no existe',
                    'detail' => 'Intente con otra modalidad',
                    'code' => '404'
                ]
            ], 400);
        }
        $modality->parent_id = $request->input('modality.parent_id');
        $modality->career_id = $request->input('modality.career_id');
        $modality->name = $request->input('modality.name');
        $modality->description = $request->input('modality.description');
        $modality->status_id = $request->input('modality.status_id');
        $modality->save();
        return response()->json([
            'data' => $modality->fresh(),
            'msg' => [
                'summary' => 'Modalidad actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }
    function delete(DeleteModalityRequest $request)
    {
        // Es una eliminación lógica
        Modality::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Modalidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }

}
