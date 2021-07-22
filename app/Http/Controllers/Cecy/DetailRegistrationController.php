<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\App\FileController;

use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\DetailRegistration\StoreDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\IndexDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\UpdateDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\DeleteDetailRegistrationRequest;

use App\Models\Cecy\DetailRegistration;
use App\Models\App\Catalogue;
use App\Models\Cecy\AdditionalInformation;
use App\Models\Cecy\DetailPlanification;

use App\Models\Cecy\Registration;

class DetailRegistrationController extends Controller
{
    //
    public function index(IndexDetailRegistrationRequest $request)
    {
        $registration = Registration::getInstance($request->input('registration.id'));

        if ($request->has('search')) {
            $detailRegistration = $registration->detailRegistrations()
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $detailRegistration = DetailRegistration::paginate($request->input('per_page'));
        }
    
        if ($detailRegistration->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron dettalles',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
    
        return response()->json($detailRegistration, 200);
     
    }

    public function show(DetailRegistration $detailRegistration)
    {
        return response()->json([
            'data' => $detailRegistration,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200); 
    }

    public function store(StoreDetailRegistrationRequest $request)
    {
        
       $registration = Registration::find($request->input('detailRegistration.registration.id'));
       $additional_information = AdditionalInformation::find($request->input('detailRegistration.additional_information.id'));
       $detail_planification = DetailPlanification::find($request->input('detailRegistration.detail_planification.id'));
       $status = Catalogue::find($request->input('detailRegistration.status.id'));
       $status_certificate = Catalogue::find($request->input('detailRegistration.status_certificate.id'));



       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       //$status = Catalogue::getInstance($request->input('status.id'));

       $detailRegistration = new DetailRegistration();
       $detailRegistration->partial_grade1 = $request->input('detailRegistration.partial_grade1');
       $detailRegistration->partial_grade2 = $request->input('detailRegistration.partial_grade2');
       $detailRegistration->final_note = $request->input('detailRegistration.final_note');
       $detailRegistration->code_certificate = $request->input('detailRegistration.code_certificate');
       $detailRegistration->certificate_withdrawn = $request->input('detailRegistration.certificate_withdrawn');
       $detailRegistration->location_certificate = $request->input('detailRegistration.location_certificate');
       $detailRegistration->observation = $request->input('detailRegistration.observation');
       //$detailRegistration->additional_information_id = $request->input('detailRegistration.additional_information_id');
       //$detailRegistration->detail_planification_id = $request->input('detailRegistration.detail_planification_id');
      //$detailRegistration->registration_id = $request->input('detailRegistration.registration_id');
       //$detailRegistration->registration()->associate($registration);
       //$detailRegistration->additionalInformation()->associate($additionalInformation);
       //$detailRegistration->detailPlanification()->associate($detailPlanification);
       $detailRegistration->registration()->associate($registration);
       $detailRegistration->additionalInformation()->associate($additional_information);
       $detailRegistration->detailPlanification()->associate($detail_planification);
       $detailRegistration->status()->associate($status);
       $detailRegistration->statusCertificate()->associate($status_certificate);


       $detailRegistration->save();

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Detalle creado',
               'detail' => 'El registro fue creado',
               'code' => '201'
           ]], 201); 
    }

    /* public function update(UpdateDetailRegistrationRequest $request, DetailRegistration $detailRegistration)
    {

    
        
        $additional_information = AdditionalInformation::find($request->input('detailRegistration.additional_information.id'));
        $detail_planification = DetailPlanification::find($request->input('detailRegistration.detail_planification.id'));
        $status = Catalogue::find($request->input('detailRegistration.status.id'));
        $status_certificate = Catalogue::find($request->input('detailRegistration.status_certificate.id'));
        
       if (!$detailRegistration) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Detalle de registro no encontrado',
                'detail' => 'Vuelva a intentar',
                'code' => '404'
            ]
        ], 404);
    }
    
    $detailRegistration->partial_grade1 = $request->input('detailRegistration.partial_grade1');
    $detailRegistration->partial_grade2 = $request->input('detailRegistration.partial_grade2');
    $detailRegistration->final_note = $request->input('detailRegistration.final_note');
    $detailRegistration->code_certificate = $request->input('detailRegistration.code_certificate');
    $detailRegistration->certificate_withdrawn = $request->input('detailRegistration.certificate_withdrawn');
    $detailRegistration->location_certificate = $request->input('detailRegistration.location_certificate');
    $detailRegistration->observation = $request->input('detailRegistration.observation');
    //$detailRegistration->additional_information_id = $request->input('detailRegistration.additional_information_id');
    //$detailRegistration->detail_planification_id = $request->input('detailRegistration.detail_planification_id');
   //$detailRegistration->registration_id = $request->input('detailRegistration.registration_id');
    //$detailRegistration->registration()->associate($registration);
    //$detailRegistration->additionalInformation()->associate($additionalInformation);
    //$detailRegistration->detailPlanification()->associate($detailPlanification);
    $detailRegistration->registration()->associate($registration);
    $detailRegistration->additionalInformation()->associate($additional_information);
    $detailRegistration->detailPlanification()->associate($detail_planification);
    $detailRegistration->status()->associate($status);
    $detailRegistration->statusCertificate()->associate($status_certificate);
    $detailRegistration->save();



       //$detailRegistration->registration()->associate($registration);
       //$detailRegistration->additionalInformation()->associate($additionalInformation);
       //$detailRegistration->detailPlanification()->associate($detailPlanification);
       

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Detalle actualizado',
               'detail' => 'El registro fue actualzado',
               'code' => '201'
           ]], 201); 
    } */

    public function recordGrades(UpdateDetailRegistrationRequest $request, DetailRegistration $detailRegistration)
    {

    
        
       
        
       if (!$detailRegistration) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Detalle de registro no encontrado',
                'detail' => 'Vuelva a intentar',
                'code' => '404'
            ]
        ], 404);
    }
    
    $detailRegistration->partial_grade1 = $request->input('detailRegistration.partial_grade1');
    $detailRegistration->partial_grade2 = $request->input('detailRegistration.partial_grade2');
    $detailRegistration->final_note = $request->input('detailRegistration.final_note');
    
   
    $partialGrade1 =$request->input('detailRegistration.partial_grade1');
    $partialGrade1=floatval($partialGrade1);
    $partialGrade2 =$request->input('detailRegistration.partial_grade2');
    $partialGrade2=floatval($partialGrade2);
    $finalNote =$request->input('detailRegistration.final_note');
    $finalNote=floatval($finalNote);


    $finalNote = ($partialGrade1 + $partialGrade2) / 2;
    $detailRegistration->final_note = $finalNote;
    
    
    $detailRegistration->save();


       
       

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Detalle actualizado',
               'detail' => 'El registro fue actualzado',
               'code' => '201'
           ]], 201); 
    }

    function delete(DeleteDetailRegistrationRequest $request)
    {
        DetailRegistration::destroy($request->input("ids")); 
        // Es una eliminación lógica
        //$detailRegistration->delete();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Detalle(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, DetailRegistration::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, DetailRegistration::getInstance($request->input('id')));

    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, DetailRegistration::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
    
}

