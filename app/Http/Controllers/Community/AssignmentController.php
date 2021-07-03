<?php

namespace App\Http\Controllers\Community;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Community\Assignment;
use App\Models\Authentication\User;

// FormRequest


class AssignmentController extends Controller 
{
	{
    public function index(Assignment $request)
    {
        //
    }

    public function store(StoreAssignmentRequest $request)
    {
        
       $data = $request -> json() ->all ();
       $user  = $data ['assignment'] ['user'];
      
        
        $assignment = new Assignment();
        
        
        $userCode = User::findOrFail($request->input('user.id'));
        $assignment->user()->associate($userCode);
                
        $assignment->date_request = $request->input('assignment.date_request');
        $assignment->status = $request->input('assignment.status');
        $assignment->observation = $request->input('assignment.observation');
        $assignment->academic_period = $request->input('assignment.academic_period');
        $assignment->level = $request->input('assignment.level');

        $project_participant->save();

        return response()->json([
            'data' => $assignment,
            'msg' => [
                'summary' => 'Solicitud Asignación creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);

    }

    public function show(Assignment $assignment)
    {
        {

            return response()->json([
                'data' => $assignment,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        } 
    }

    public function update(Assignment $request, Assignment $assignment)
    {
        //
    }

    public function destroy(Assignment $assignment)
    {
        //
    }	

}
