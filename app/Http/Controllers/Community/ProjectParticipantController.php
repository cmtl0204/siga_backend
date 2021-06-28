<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Http\Requests\Community\ProjectParticipant\IndexProjectParticipantRequest;
use App\Http\Requests\Community\ProjectParticipant\StoreProjectParticipantRequest;
use App\Http\Requests\Community\ProjectParticipant\UpdateProjectParticipantRequest;
use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use App\Models\Community\Project;
use App\Models\Community\ProjectParticipant;

class ProjectParticipantController extends Controller
{
    public function index(IndexProjectParticipantRequest $request)
    {
        $project_participants = ProjectParticipant::with('project')->with('type')->with('user')
                    ->paginate($request->input('per_page'));
        return response()->json([
            'data' => $project_participants,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function show(ProjectParticipant $project_participant)
    {
        return response()->json([
            'data' => $project_participant,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(StoreProjectParticipantRequest $request)
    {
        $project_participant = new ProjectParticipant();
        $project_participant->start_date = $request->input('project_participant.start_date');
        $project_participant->end_date = $request->input('project_participant.end_date');
        $project_participant->schedule_job = $request->input('project_participant.schedule_job');
        $project_participant->position = $request->input('project_participant.position');
        $project_participant->working_hours = $request->input('project_participant.working_hours');
        $project_participant->functions = $request->input('project_participant.functions');
        $project_participant->state = $request->input('project_participant.state');

        $projectCode = Project::findOrFail($request->input('project.id'));
        $typeCode = Catalogue::findOrFail($request->input('type.id'));
        $userCode = User::findOrFail($request->input('user.id'));

        $project_participant->project()->associate($projectCode);
        $project_participant->type()->associate($typeCode);
        $project_participant->user()->associate($userCode);

        $project_participant->save();

        return response()->json([
            'data' => $project_participant,
            'msg' => [
                'summary' => 'Participante de Proyecto creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateProjectParticipantRequest $request, ProjectParticipant $project_participant)
    {
        $project_participant->start_date = $request->input('project_participant.start_date');
        $project_participant->end_date = $request->input('project_participant.end_date');
        $project_participant->schedule_job = $request->input('project_participant.schedule_job');
        $project_participant->position = $request->input('project_participant.position');
        $project_participant->working_hours = $request->input('project_participant.working_hours');
        $project_participant->functions = $request->input('project_participant.functions');
        $project_participant->state = $request->input('project_participant.state');

        $project_participant->save();
        return response()->json([
            'data' => $project_participant,
            'msg' => [
                'summary' => 'Participante de Proyecto actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    public function destroy(ProjectParticipant $project_participant)
    {
        $project_participant->delete();
        return response()->json([
            'data' => $project_participant,
            'msg' => [
                'summary' => 'Participante de proyecto eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

}
