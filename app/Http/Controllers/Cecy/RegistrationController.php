<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Registration\DeleteRegistrationRequest;
use App\Http\Requests\Cecy\Registration\IndexRegistrationRequest;
use App\Http\Requests\Cecy\Registration\StoreRegistrationRequest;
use App\Http\Requests\Cecy\Registration\UpdateRegistrationRequest;

use App\Models\Cecy\Registration;
use App\Models\App\Status;
use App\Models\App\Catalogue;
use App\Models\Cecy\AdditionalInformation;
use App\Models\Cecy\DetailRegistration;

// use App\Models\JobBoard\Category;
// use App\Models\JobBoard\Professional;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;

class RegistrationController extends Controller
{
    function index(IndexRegistrationRequest $request)
    {
        $regitration = Registration::all();

        return response()->json([
            'data' => $regitration,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);

            // if($request->has('search')){
            //     $registration = $registration
            // }
    }

    function show(Registration $registration)
    {
        return response()->json([
            'data' => $registration,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code'=> '200'
            ]], 200);
    }

    function store(StoreRegistrationRequest $request)
    {
        $data = $request->json()->all();
        // $dataRegistration = $data['registration'];
        // $dataParticipant = $data['participant_id'];
        // $dataStatu = $data['status_id'];
        // $dataType = $data['type_id'];
        // $planification = Planification::find($request->input('registration.planification_id'));
        $additional = new AdditionalInformation();
        if ($request->input('additional_information')) {
            $additional->company_activity = $request->input('additional_information.company_activity');
            $additional->company_address = $request->input('additional_information.company_address');
            $additional->company_name = $request->input('additional_information.company_name');
            $additional->company_phone = $request->input('additional_information.company_phone');
            $additional->company_sponsor = $request->input('additional_information.company_sponsor');
            $additional->course_follow = $request->input('additional_information.course_follow');
            $additional->know_course = $request->input('additional_information.know_course');
            $additional->level_instruction = $request->input('additional_information.level_instruction');
            $additional->name_contact = $request->input('additional_information.name_contact');
            $additional->works = $request->input('additional_information.works');
            $additional->save();
        }

        $registration = new Registration();
        $registration->date_registration = $request->input('registration.date_registration');
        $registration->number = $request->input('registration.number');
        $registration->planification_id = $request->input('registration.planification_id');
        $registration->status_id = $request->input('registration.status_id');
        $registration->type_id = $request->input('registration.type_id');
        // $registration->planification()->assosiate($planification);
        $registration->status()->associate(Status::findOrFail($request->input('registration.status_id')));
        $registration->type()->associate(Catalogue::findOrFail($request->input('registration.type_id')));
        $registration->save();

        $detailRegistration = new DetailRegistration();
        $detailRegistration->registration_id = $registration->id;
        $detailRegistration->additional_information_id = $additional->id;
        $detailRegistration->detail_planification_id = $registration->planification_id;
        $detailRegistration->save();

        return response()->json([
            'data' => $registration->fresh(),
            'msg' => [
                'summary' => 'Registro actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        $data = $request->json()->all();

        $status = $data['registration']['status'];
        $type = $data['registration']['type'];

        // $registration->date = $request->input('registration.date');
        $registration->date_registration = $request->input('registration.date_registration');
        $registration->number = $request->input('registration.number');
        $registration->planification_id = $request->input('registration.planification_id');
        // $registration->status_id = $request->input('registration.status_id');
        // $registration->type_id = $request->input('registration.type_id');
        $registration->status()->associate(Status::findOrFail($status['id']));
        $registration->type()->associate(Catalogue::findOrFail($type['id']));

        $registration->save();

        return response()->json([
            'data' => $registration->fresh(),
            'msg' => [
                'summary' => 'Registro actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteRegistrationRequest $request)
    {
        Registration::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Registro(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }

    function exportTest(){
        return Excel::download(new RegistrationsExport, 'registration.xlsx');
    }
}