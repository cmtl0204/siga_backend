<?php

namespace App\Http\Controllers\JobBoard;
//controllers
use App\Http\Controllers\Controller;

//models
use App\Models\JobBoard\Professional;

//formRequest
use App\Http\Requests\JobBoard\Professional\UpdateProfessionalRequest;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    function getCompanies(Request $request)
    {
        $professional = Professional::find(1);
        $offers = $professional->companies()->paginate();
        return response()->json($offers, 200);
    }

    function getOffers(Request $request)
    {
        $professional = Professional::find(1);
        $offers = $professional->offers()->paginate();
        return response()->json($offers);
    }

    function show(Professional $professional)
    {
        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function update(UpdateProfessionalRequest $request, Professional $professional)
    {
        $professional = Professional::find($professionalId);

        $professional->has_travel = $request->input('professional.has_travel');
        $professional->has_license = $request->input('professional.has_license');
        $professional->has_disability = $request->input('professional.has_disability');
        $professional->has_familiar_disability = $request->input('professional.has_familiar_disability');
        $professional->identification_familiar_disability = $request->input('professional.identification_familiar_disability');
        $professional->has_catastrophic_illness = $request->input('professional.has_catastrophic_illness');
        $professional->familiar_catastrophic_illness = $request->input('professional.familiar_catastrophic_illness');
        $professional->about_me = $request->input('professional.about_me');
        $professional->save();
    }

    function destroy(Professional $professional)
    {
        $professional->delete();

        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'Profesional eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]
        ], 201);
    }

    function getProfessional(Request $request)
    {
        $professional = $request->user()->professional()->first();

        if (!$professional) {
            return response()->json([
                'data' => $professional,
                'msg' => [
                    'summary' => 'Profesional no encontrado',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404',
                ]
            ], 404);
        }
        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]
        ], 200);
    }
}