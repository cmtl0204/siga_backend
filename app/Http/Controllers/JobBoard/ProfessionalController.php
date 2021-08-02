<?php

namespace App\Http\Controllers\JobBoard;

//Controllers
use App\Http\Controllers\Controller;

//Models
use App\Models\App\Catalogue;
use App\Models\App\Address;
use App\Models\Authentication\User;
use App\Models\App\Location;

// FormRequest
use App\Http\Requests\JobBoard\Professional\GetProfessionalRequest;
use App\Models\JobBoard\Professional;
use App\Http\Requests\JobBoard\Professional\UpdateProfessionalRequest;

class ProfessionalController extends Controller
{
    function getProfessional(GetProfessionalRequest $request)
    {
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => $professional,
                'msg' => [
                    'summary' => 'professional no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404',
                ]
            ], 404);
        }
        // $course = $professional->course()->with('professional')->first();
        // $skill = $professional->skill()->with('professional')->first();

        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]
        ], 200);
    }

    function updateProfessional(UpdateProfessionalRequest $request)
    {
        // Crea una instanacia del modelo Catalogue para poder actualizar en el modelo Professional.
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $user = $request->user();
        $address = $user->address()->first() ? $user->address()->first() : new Address();
        $location = Location::find($request->input('professional.user.address.location.id'));
        $sector = Catalogue::find($request->input('professional.user.address.sector.id'));
        $address->main_street = $request->input('professional.user.address.main_street');
        $address->secondary_street = $request->input('professional.user.address.secondary_street');
        $address->number = $request->input('professional.user.address.number');
        $address->post_code = $request->input('professional.user.address.post_code');
        $address->reference = $request->input('professional.user.address.reference');
        $address->longitude = $request->input('professional.user.address.longitude');
        $address->latitude = $request->input('professional.user.address.latitude');
        $address->location()->associate($location);
        $address->sector()->associate($sector);
        $address->save();

        $identificationType = Catalogue::find($request->input('professional.user.identification_type.id'));
        $user->username = $request->input('professional.user.identification');
        $user->identification = $request->input('professional.user.identification');
        $user->email = $request->input('professional.user.maiel');
        $user->names = $request->input('professional.user.names');
        $user->firtLastname = $request->input('professional.user.firt_lastname');
        $user->secondLasname = $request->input('professional.user.second_lastname');
        $user->phone = $request->input('professional.user.phone');
        $user->identificationType()->associate($identificationType);
        $user->address()->associate($address);
        $user->save();

        $sex = Catalogue::find($request->input('professional.sex.id'));
        $gender = Catalogue::find($request->input('professional.gender.id'));
        $professional = $request->user()->professional()->first();
        $professional->is_travel = $request->input('professional.is_travel');
        $professional->is_disability = $request->input('professional.is_disability');
        $professional->is_familiar_disability = $request->input('professional.is_familiar_disability');
        $professional->identification_familiar_disability = $request->input('professional.identification_familiar_disability');
        $professional->is_catastrophic_illness = $request->input('professional.is_catastrophic_illness');
        $professional->is_familiar_catastrophic_illness = $request->input('professional.is_familiar_catastrophic_illness');
        $professional->about_me = $request->input('professional.about_me');
        $professional->sex()->associate($sex);
        $professional->tgender()->associate($gender);
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
}