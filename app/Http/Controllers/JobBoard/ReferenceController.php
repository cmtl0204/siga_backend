<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobBoard\Reference\CreateReferenceRequest;
use App\Http\Requests\JobBoard\Reference\IndexReferenceRequest;
use App\Http\Requests\JobBoard\Reference\UpdateReferenceRequest;
use App\Models\JobBoard\Reference;
use App\Models\JobBoard\Professional;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    function  test(Request $request)
    {
        return Professional::select('about_me', 'has_travel')->with('course')->get();
    }

    function index(IndexReferenceRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder consultar en el modelo course.
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        //$professional = Professional::getInstance($request->input('professional_id'));
        if ($request->has('search')) {
            $references = $professional->references()
                ->institution($request->input('search'))
                ->position($request->input('search'))
                ->contactName($request->input('search'))
                ->contactPhone($request->input('search'))
                ->contactEmail($request->input('search'))
                ->get();
        } else {
            $references = $professional->references()->paginate($request->input('per_page'));
        }

        if ($references->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Referencias',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        return response()->json($references, 200);
    }

    function show(Reference $reference)
    {
        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function store(CreateReferenceRequest $request)
    {
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        //$professional = Professional::getInstance($request->input('professional.id'));
        $reference = new Reference();
        $reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');
        $reference->professional()->associate($professional);
        $reference->save();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function update(UpdateReferenceRequest $request, $id)
    {
        $reference = Reference::find($id);

        if (!$reference) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Referencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]
            ], 404);
        }

        $reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');
        $reference->save();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia actualizada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function destroy(Reference $reference)
    {
        $reference->delete();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Oferta eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]
        ], 201);
    }
}