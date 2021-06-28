<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Http\Requests\Community\Project\IndexProjectRequest;
use App\Http\Requests\Community\Project\StoreProjectRequest;
use App\Http\Requests\Community\Project\UpdateProjectRequest;
use App\Models\Community\Project;

class ProjectController extends Controller
{
    public function index(IndexProjectRequest $request)
    {
        $projects = Project::with('entity')->with('schoolPeriod')->with('career')->with('coverage')
                    ->with('location')->with('frequency')->with('status')->with('createdBy')
                    ->paginate($request->input('per_page'));
        return response()->json([
            'data' => $projects,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function show(Project $project)
    {
        return response()->json([
            'data' => $project,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = new Project();
        $project->code = $request->input('project.code');
        $project->title = $request->input('project.title');
        $project->date = $request->input('project.date');
        $project->cycles = $request->input('project.cycles');
        $project->lead_time = $request->input('project.lead_time');
        $project->delivery_date = $request->input('project.delivery_date');
        $project->start_date = $request->input('project.start_date');
        $project->end_date = $request->input('project.end_date');
        $project->description = $request->input('project.description');
        $project->diagnosis = $request->input('project.diagnosis');
        $project->justification = $request->input('project.justification');
        $project->direct_beneficiaries = $request->input('project.direct_beneficiaries');
        $project->indirect_beneficiaries = $request->input('project.indirect_beneficiaries');
        $project->strategies = $request->input('project.strategies');
        $project->bibliografies = $request->input('project.bibliografies');
        $project->observations = $request->input('project.observations');
        $project->send_quipux = $request->input('project.send_quipux');
        $project->receive_quipux = $request->input('project.receive_quipux');
        $project->state = $request->input('project.state');

        // $entityCode = Entity::findOrFail($request->input('entity.id'));
        // $schoolPeriodCode = SchoolPeriod::findOrFail($request->input('school_period.id'));
        // $careerCode = Career::findOrFail($request->input('career.id'));
        // $coverageCode = Catalogue::findOrFail($request->input('coverage.id'));
        // $locationCode = Location::findOrFail($request->input('location.id'));
        // $frequencyCode = Catalogue::findOrFail($request->input('frequency.id'));
        // $statusCode = Catalogue::findOrFail($request->input('status.id'));
        // $createdByCode = User::findOrFail($request->input('created_by.id'));

        // $project->entity()->associate($entityCode);
        // $project->schoolPeriod()->associate($schoolPeriodCode);
        // $project->career()->associate($careerCode);
        // $project->coverage()->associate($coverageCode);
        // $project->location()->associate($locationCode);
        // $project->frequency()->associate($frequencyCode);
        // $project->status()->associate($statusCode);
        // $project->createdBy()->associate($createdByCode);

        $project->save();

        return response()->json([
            'data' => $project,
            'msg' => [
                'summary' => 'Proyecto creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->code = $request->input('project.code');
        $project->title = $request->input('project.title');
        $project->date = $request->input('project.date');
        $project->cycles = $request->input('project.cycles');
        $project->lead_time = $request->input('project.lead_time');
        $project->delivery_date = $request->input('project.delivery_date');
        $project->start_date = $request->input('project.start_date');
        $project->end_date = $request->input('project.end_date');
        $project->description = $request->input('project.description');
        $project->diagnosis = $request->input('project.diagnosis');
        $project->justification = $request->input('project.justification');
        $project->direct_beneficiaries = $request->input('project.direct_beneficiaries');
        $project->indirect_beneficiaries = $request->input('project.indirect_beneficiaries');
        $project->strategies = $request->input('project.strategies');
        $project->bibliografies = $request->input('project.bibliografies');
        $project->observations = $request->input('project.observations');
        $project->send_quipux = $request->input('project.send_quipux');
        $project->receive_quipux = $request->input('project.receive_quipux');
        $project->state = $request->input('project.state');

        $project->save();
        return response()->json([
            'data' => $project,
            'msg' => [
                'summary' => 'Proyecto actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'data' => $project,
            'msg' => [
                'summary' => 'Proyecto eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

}
