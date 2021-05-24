<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\PlanificationInstructor\DeletePlanificationInstructorRequest;
use App\Http\Requests\Cecy\PlanificationInstructor\IndexPlanificationInstructorRequest;
use App\Http\Requests\Cecy\PlanificationInstructor\StorePlanificationInstructorRequest;
use App\Http\Requests\Cecy\PlanificationInstructor\UpdatePlanificationInstructorRequest;

use App\Models\Cecy\PlanificationInstructor;
// use App\Models\JobBoard\Category;
// use App\Models\JobBoard\Professional;

class PlanificationInstructorController extends Controller
{
    function index(IndexPlanificationInstructorRequest $request)
    {
        $planificationInstructor = PlanificationInstructor::all();

        return response()->json([
            'data' => $planificationInstructor,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function show(PlanificationInstructor $planificationInstructor)
    {
        return response()->json([
            'data' => $planificationInstructor,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code'=> '200'
            ]], 200);
    }

    function store(StorePlanificationInstructorRequest $request)
    {
        $data = $request->json()->all();
        // $dataRegistration = $data['registration'];
        // $dataParticipant = $data['participant_id'];
        // $dataStatu = $data['status_id'];
        // $dataType = $data['type_id'];

        $planificationInstructor = new PlanificationInstructor();
        $planificationInstructor->instructor_id = $request->input('planification_instructor.instructor_id');
        $planificationInstructor->planification_id = $request->input('planification_instructor.planification_id');
        $planificationInstructor->save();
        
        return response()->json([
            'data' => $planificationInstructor->fresh(),
            'msg' => [
                'summary' => 'Planification instructor fue creada',
                'detail' => 'El registro fue creado con exito',
                'code' => '201'
            ]], 201);
    }

    function update(UpdatePlanificationInstructorRequest $request, PlanificationInstructor $planificationInstructor)
    {
        $planificationInstructor->instructor_id = $request->input('planification_instructor.instructor_id');
        $planificationInstructor->planification_id = $request->input('planification_instructor.planification_id');
        $planificationInstructor->save();

        return response()->json([
            'data' => $planificationInstructor->fresh(),
            'msg' => [
                'summary' => 'Planificacion e Instructor actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeletePlanificationInstructorRequest $request)
    {
        PlanificationInstructor::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Registro(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
}