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
        // $status = Status::find($request->input('registration.status_id'));
        // $type = Catalogue::find($request->input('registration.type_id'));
        $status = $data['registration']['status'];
        $type = $data['registration']['type'];
        

        $registration = new Registration();
         $registration->date_registration = $request->input('registration.date_registration');
        $registration->number = $request->input('registration.number');
        $registration->planification_id = $request->input('registration.planification_id');
        // $registration->status_id = $request->input('registration.status_id');
        // $registration->type_id = $request->input('registration.type_id');
        // $registration->planification()->assosiate($planification);
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