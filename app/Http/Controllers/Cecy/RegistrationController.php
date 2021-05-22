<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Registration\DeleteRegistrationRequest;
use App\Http\Requests\Cecy\Registration\IndexRegistrationRequest;
use App\Http\Requests\Cecy\Registration\StoreRegistrationRequest;
use App\Http\Requests\Cecy\Registration\UpdateRegistrationRequest;

use App\Models\Cecy\Registration;
// use App\Models\JobBoard\Category;
// use App\Models\JobBoard\Professional;

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

        $registration = new Registration();
         $registration->date = $request->input('registration.date');
        $registration->number = $request->input('registration.number');
        $registration->participant_id = $request->input('registration.participant_id');
        $registration->status_id = $request->input('registration.status_id');
        $registration->type_id = $request->input('registration.type_id');
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
        // $registration->date = $request->input('registration.date');
        $registration->date = $request->input('registration.date');
        $registration->number = $request->input('registration.number');
        $registration->participant_id = $request->input('registration.participant_id');
        $registration->status_id = $request->input('registration.status_id');
        $registration->type_id = $request->input('registration.type_id');

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
}