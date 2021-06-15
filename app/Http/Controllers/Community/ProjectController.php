<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community\Project;
use App\Models\App\Catalogue;
use App\Models\Community\Entity;
use App\Models\App\SchoolPeriod;
use App\Models\App\Career;
use App\Models\App\Location;
use App\Models\Authentication\User;

class ProjectController extends Controller
{
    public function index(IndexProjectRequest $request)
    {
        $projects = Project::with('entity')->with('schoolPeriod')->with('career')->with('coverage')
                    ->with('location')->with('frequency')->with('status')->with('createdBy')->get();
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

    public function store(CreateProjectRequest $request)
    {
        $data = $request->json()->all();
        $dataProject = $data['project'];
        $dataEntityCode = $data['entity_code'];
        $dataSchoolPeriodCode = $data['school_period_code'];
        $dataCareerCode = $data['career_code'];
        $dataCoverageCode = $data['coverage_code'];
        $dataLocationCode = $data['location_code'];
        $dataFrequencyCode = $data['frequency_code'];
        $dataStatusCode = $data['status_code'];
        $dataCreatedByCode = $data['created_by_code'];

        $project = new Project();
        $project->code = $dataProject['code'];
        $project->title = $dataProject['title'];
        $project->date = $dataProject['date'];
        $project->cycles = $dataProject['cycles'];
        $project->lead_time = $dataProject['lead_time'];
        $project->delivery_date = $dataProject['delivery_date'];
        $project->start_date = $dataProject['start_date'];
        $project->end_date = $dataProject['end_date'];
        $project->description = $dataProject['description'];
        $project->diagnosis = $dataProject['diagnosis'];
        $project->justification = $dataProject['justification'];
        $project->direct_beneficiaries = $dataProject['direct_beneficiaries'];
        $project->indirect_beneficiaries = $dataProject['indirect_beneficiaries'];
        $project->strategies = $dataProject['strategies'];
        $project->bibliografies = $dataProject['bibliografies'];
        $project->observations = $dataProject['observations'];
        $project->send_quipux = $dataProject['send_quipux'];
        $project->receive_quipux = $dataProject['receive_quipux'];
        $project->state = $dataProject['state'];

        $entityCode = Entity::findOrFail($dataEntityCode['id']);
        $schoolPeriodCode = SchoolPeriod::findOrFail($dataSchoolPeriodCode['id']);
        $careerCode = Career::findOrFail($dataCareerCode['id']);
        $coverageCode = Catalogue::findOrFail($dataCoverageCode['id']);
        $locationCode = Location::findOrFail($dataLocationCode['id']);
        $frequencyCode = Catalogue::findOrFail($dataFrequencyCode['id']);
        $statusCode = Catalogue::findOrFail($dataStatusCode['id']);
        $createdByCode = User::findOrFail($dataCreatedByCode['id']);

        $project->entity()->associate($entityCode);
        $project->schoolPeriod()->associate($schoolPeriodCode);
        $project->career()->associate($careerCode);
        $project->coverage()->associate($coverageCode);
        $project->location()->associate($locationCode);
        $project->frequency()->associate($frequencyCode);
        $project->status()->associate($statusCode);
        $project->createdBy()->associate($createdByCode);

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
        $data = $request->json()->all();
        $dataProject = $data['project'];
        $project->code = $dataProject['code'];
        $project->title = $dataProject['title'];
        $project->date = $dataProject['date'];
        $project->cycles = $dataProject['cycles'];
        $project->lead_time = $dataProject['lead_time'];
        $project->delivery_date = $dataProject['delivery_date'];
        $project->start_date = $dataProject['start_date'];
        $project->end_date = $dataProject['end_date'];
        $project->description = $dataProject['description'];
        $project->diagnosis = $dataProject['diagnosis'];
        $project->justification = $dataProject['justification'];
        $project->direct_beneficiaries = $dataProject['direct_beneficiaries'];
        $project->indirect_beneficiaries = $dataProject['indirect_beneficiaries'];
        $project->strategies = $dataProject['strategies'];
        $project->bibliografies = $dataProject['bibliografies'];
        $project->observations = $dataProject['observations'];
        $project->send_quipux = $dataProject['send_quipux'];
        $project->receive_quipux = $dataProject['receive_quipux'];
        $project->state = $dataProject['state'];

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
