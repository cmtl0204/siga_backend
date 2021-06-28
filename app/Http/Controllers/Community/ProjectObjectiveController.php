<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Http\Requests\Community\ProjectObjective\IndexProjectObjectiveRequest;
use App\Http\Requests\Community\ProjectObjective\StoreProjectObjectiveRequest;
use App\Http\Requests\Community\ProjectObjective\UpdateProjectObjectiveRequest;
use App\Models\App\Catalogue;
use App\Models\Community\Project;
use App\Models\Community\ProjectObjective;

class ProjectObjectiveController extends Controller
{
    public function index(IndexProjectObjectiveRequest $request)
    {
        $project_objectives = ProjectObjective::with('project')->with('type')->with('parent')->with('children')
                    ->paginate($request->input('per_page'));
        return response()->json([
            'data' => $project_objectives,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function show(ProjectObjective $project_objective)
    {
        return response()->json([
            'data' => $project_objective,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(StoreProjectObjectiveRequest $request)
    {
        $project_objective = new ProjectObjective();
        $project_objective->code = $request->input('project_objective.code');
        $project_objective->description = $request->input('project_objective.description');
        $project_objective->verification_means = $request->input('project_objective.verification_means');
        $project_objective->state = $request->input('project_objective.state');

        $projectCode = Project::findOrFail($request->input('project.id'));
        $typeCode = Catalogue::findOrFail($request->input('type.id'));
        $parentCode = ProjectObjective::findOrFail($request->input('parent.id'));

        $project_objective->project()->associate($projectCode);
        $project_objective->type()->associate($typeCode);
        $project_objective->parent()->associate($parentCode);

        $project_objective->save();

        return response()->json([
            'data' => $project_objective,
            'msg' => [
                'summary' => 'Objetivo de Proyecto creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateProjectObjectiveRequest $request, ProjectObjective $project_objective)
    {
        $project_objective->code = $request->input('project_objective.code');
        $project_objective->description = $request->input('project_objective.description');
        $project_objective->verification_means = $request->input('project_objective.verification_means');
        $project_objective->state = $request->input('project_objective.state');

        $project_objective->save();
        return response()->json([
            'data' => $project_objective,
            'msg' => [
                'summary' => 'Objetivo de Proyecto actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    public function destroy(ProjectObjective $project_objective)
    {
        $project_objective->delete();
        return response()->json([
            'data' => $project_objective,
            'msg' => [
                'summary' => 'Objetivo de proyecto eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

}
