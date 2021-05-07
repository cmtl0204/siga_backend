<?php

namespace App\Http\Controllers\JobBoard;
//controllers
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
//models
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Catalogue;
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Skill;
use App\Models\JobBoard\Offer;
use App\Models\JobBoard\Reference;
use App\Models\JobBoard\Experience;





//formRequest
use App\Http\Requests\JobBoard\Professional\UpdateProfessionalRequest;


class ProfessionalController extends Controller
{
    function getCompanies(Request $request)
    {
        $professional = Professional::find(1);
        $offers = $professional->companies()->paginate();
        return response()->json($offers,200);
    }

    function getOffers(Request $request)
    {
        $professional = Professional::find(1);
        $offers = $professional->offers()->paginate();
        return response()->json($offers);
    }

    function show($professionalId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        $professional = Professional::find($professionalId);
        if (!$professional) {

            return response()->json([
                'data' => $professional,
                'msg' => [
                    'summary' => 'Profesional no encontrado',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404',
                ]], 404);
            // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        }
        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]], 200);
    }

    function update(UpdateProfessionalRequest $request, $professionalId)
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

    function destroy($professionalId)
    {
        $professional = Professional::find($professionalId);
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Professional no encontrado',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $professional->delete();

        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'Profesional eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

}
