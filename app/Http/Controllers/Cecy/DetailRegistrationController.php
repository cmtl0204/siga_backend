<?php

namespace App\Http\Controllers\Cecy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\DetailRegistration\StoreDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\IndexDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\UpdateDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\DeleteDetailRegistrationRequest;
use App\Models\App\Status;
use App\Models\Cecy\Participant;
use App\Models\Cecy\DetailRegistration;
use App\Models\App\Catalogue;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;

class DetailRegistrationController extends Controller
{
    //
    public function index()
    {
           // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
    $registration = Registration::getInstance($request->input('registration_id'));

    if ($request->has('search')) {
        $detailRegistrations = $registration->detailRegistrations()
            ->description($request->input('search'));
            ->additional_information_id($request->input('search'));
            ->detail_planification_id($request->input('search'));
            ->status_id($request->input('search'));
            ->partial_grade($request->input('search'));
            ->final_exam($request->input('search'));
            ->code_certificate($request->input('search'));
            ->status_certificate_id($request->input('search'));
            ->certificate_withdrawn($request->input('search'));
            ->location_certificate($request->input('search'));
            ->observation($request->input('search'));
            ->paginate($request->input('per_page'));
    } else {
        $detailRegistrations = $registration->detailRegistrations()->paginate($request->input('per_page'));
    }

    if ($detailRegistrations->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron Habilidades',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($detailRegistrations, 200); 
    }

    public function show()
    {
        return response()->json([
            'data' => $detailRegistration,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200); 
    }

    public function store()
    {
       // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       $registration = Registration::getInstance($request->input('registration.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       $status = Catalogue::getInstance($request->input('status.id'));

       $detailRegistration = new DetailRegistration();
       $detailRegistration->partial_grade = $request->input('detailRegistration.partial_grade');
       $detailRegistration->final_exam = $request->input('detailRegistration.final_exam');
       $detailRegistration->code_certificate = $request->input('detailRegistration.code_certificate');
       $detailRegistration->certificate_withdrawn = $request->input('detailRegistration.certificate_withdrawn');
       $detailRegistration->location_certificate = $request->input('detailRegistration.location_certificate');
       $detailRegistration->observation = $request->input('detailRegistration.observation');
       //$detailRegistration->registration()->associate($registration);
       $detailRegistration->additionalInformation()->associate($additionalInformation);
       $detailRegistration->detailPlanification()->associate($detailPlanification);
       $detailRegistration->status()->associate($status);
       $detailRegistration->statusCertificate()->associate($statusCertificate);
       $detailRegistration->save();

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Habilidad creada',
               'detail' => 'El registro fue creado',
               'code' => '201'
           ]], 201); 
    }

    public function update()
    {
         // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       $registration = Registration::getInstance($request->input('registration.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       $status = Catalogue::getInstance($request->input('status.id'));

       $detailRegistration->partial_grade = $request->input('detailRegistration.partial_grade');
       $detailRegistration->final_exam = $request->input('detailRegistration.final_exam');
       $detailRegistration->code_certificate = $request->input('detailRegistration.code_certificate');
       $detailRegistration->certificate_withdrawn = $request->input('detailRegistration.certificate_withdrawn');
       $detailRegistration->location_certificate = $request->input('detailRegistration.location_certificate');
       $detailRegistration->observation = $request->input('detailRegistration.observation');
       //$detailRegistration->registration()->associate($registration);
       $detailRegistration->additionalInformation()->associate($additionalInformation);
       $detailRegistration->detailPlanification()->associate($detailPlanification);
       //$detailRegistration->status()->associate($status);
       //$detailRegistration->statusCertificate()->associate($statusCertificate);
       $detailRegistration->save();

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Habilidad creada',
               'detail' => 'El registro fue creado',
               'code' => '201'
           ]], 201); 
    }

    function delete(DeleteDetailRegistrationRequest $request)
    {
        // Es una eliminación lógica
        DetailRegistration::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Habilidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
}

