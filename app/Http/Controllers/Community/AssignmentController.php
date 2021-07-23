<?php

namespace App\Http\Controllers\Community;

// Controllers
use App\Http\Controllers\Controller;
use App\Http\Requests\Community\Assignment\StoreAssignmentRequest;
// Models
use App\Models\Community\Assignment;
use App\Models\Authentication\User;
use App\Models\App\Career;
use Illuminate\Http\Request;

// FormRequest


class AssignmentController extends Controller 
{
    public function index(Request $request)
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

    public function getAssignment(Request $request)
    {
        $id = $request->input('user_id');
        $assignment = Assignment::where('user_id', $id)->with('user')->with('career')->latest('created_at')->first();
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

        $assignment = new Assignment();
        
        $userCode = User::findOrFail($request->input('user.id'));
        $assignment->user()->associate($userCode);
        $careerCode = Career::findOrFail($request->input('career.career.id'));
        $assignment->career()->associate($careerCode);
                
        $assignment->date_request = $request->input('date_request');
        $assignment->status = $request->input('status');
        $assignment->observation = $request->input('observation');
        $assignment->level = $request->input('level');

        $assignment->save();

        return response()->json([
            'data' => $assignment,
            'msg' => [
                'summary' => 'Solicitud Asignación creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);

    }

    public function show(Request $request)
    {
        $id = $request->input('user_id');
        $assignment = Assignment::where('user_id', $id)->first();
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
