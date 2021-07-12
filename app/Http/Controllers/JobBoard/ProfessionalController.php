<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Requests\JobBoard\Company\IndexProfessionalRequest;
//controllers
use App\Http\Controllers\Controller;

//models
use App\Models\JobBoard\Professional;
use App\Models\Authentication\User;

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
        $user = $request->user();
        $user->identification = $request->input('professional.user.identification');
        $user->email = $request->input('professional.user.email');
        $user->firtName = $request->input('professional.user.firt_name');
        $user->secondName = $request->input('professional.user.second_name');
        $user->firtLastname = $request->input('professional.user.firt_lastname');
        $user->secondLasname = $request->input('professional.user.second_lastname');
        $user->phone = $request->input('prfessional.user.phone');
        $user->save();
        $professional->is_travel = $request->input('professional.is_travel');
        $professional->is_disability = $request->input('professional.is_disability');
        $professional->is_familiar_disability = $request->input('professional.is_familiar_disability');
        $professional->identification_familiar_disability = $request->input('professional.identification_familiar_disability');
        $professional->is_catastrophic_illness = $request->input('professional.is_catastrophic_illness');
        $professional->is_familiar_catastrophic_illness = $request->input('professional.is_familiar_catastrophic_illness');
        $professional->about_me = $request->input('professional.about_me');
        $professional->save();

        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'Profesional actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
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