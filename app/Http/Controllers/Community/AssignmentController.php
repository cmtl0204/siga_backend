<?php

namespace App\Http\Controllers\Community;

// Controllers
use App\Http\Controllers\Controller;
use App\Http\Requests\Community\Assignment\StoreAssignmentRequest;
// Models
use App\Models\Community\Assignment;
use App\Models\Authentication\User;
use App\Models\App\Career;

// FormRequest


class AssignmentController extends Controller 
{

    public function getAssignment(Assignment $request)
    {
        $assignment = Assignment::with('user_id')->with('career_id')->paginate($request->input('per_page'));
        return response()->json([
            'data' => $assignment,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(StoreAssignmentRequest $request)
    {
        
       $data = $request -> json() ->all ();
       $user  = $data ['assignment'] ['user'];
       $career  = $data ['assignment'] ['career'];
      
        
        $assignment = new Assignment();
        
        
        $userCode = User::findOrFail($request->input('user.id'));
        $assignment->user()->associate($userCode);
        $careerCode = Career::findOrFail($request->input('career.id'));
        $assignment->career()->associate($careerCode);
                
        $assignment->date_request = $request->input('assignment.date_request');
        $assignment->status = $request->input('assignment.status');
        $assignment->observation = $request->input('assignment.observation');
        $assignment->level = $request->input('assignment.level');

        $assignment->save();

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
        return response()->json([
            'data' => $assignment,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
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
