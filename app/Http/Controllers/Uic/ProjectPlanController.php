<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\ProjectPlan\DeleteProjectPlanRequest;
use App\Http\Requests\Uic\ProjectPlan\IndexProjectPlanRequest;
use App\Http\Requests\Uic\ProjectPlan\StoreProjectPlanRequest;
use App\Http\Requests\Uic\ProjectPlan\UpdateProjectPlanRequest;
use App\Models\Uic\ProjectPlan;
use Illuminate\Http\Request;
use App\Models\Uic\Requirement;

class ProjectPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexProjectPlanRequest $request)
    {
        if ($request->has('search')) {
            $projectPlans = ProjectPlan::title($request->input('search'))
                ->description($request->input('search'))->paginate($request->input('per_page'));
        } else {
            $projectPlans = ProjectPlan::paginate($request->input('per_page'));
        }
        if ($projectPlans->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron planes de proyectos',
                    'detail' => 'Intentalo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($projectPlans, 200);
    }

    public function show(ProjectPlan $projectPlan)
    {
        if (!$projectPlan) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El plan de proyecto no existe',
                    'detail' => 'Intente con otro plan de proyecto',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $projectPlan,
            'msg' => [
                'summary' => '',
                'detail' => '',
                'code' => '200'
            ]

        ], 200);
    }

    public function store(StoreProjectPlanRequest $request)
    {
        $projectPlan = new ProjectPlan;
        $projectPlan->title = $request->input('projectPlan.title');
        $projectPlan->description = $request->input('projectPlan.description');
        $projectPlan->act_code = $request->input('projectPlan.act_code');
        $projectPlan->approval_date = $request->input('projectPlan.approval_date');
        $projectPlan->is_approved = $request->input('projectPlan.is_approved');
        $projectPlan->observations = $request->input('projectPlan.observations');
        $projectPlan->save();
        return response()->json([
            'data' => $projectPlan->fresh(),
            'msg' => [
                'summary' => 'Proyecto creado',
                'detail' => 'El proyecto fue creado con exito',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateProjectPlanRequest $request, $id)
    {
        $projectPlan = ProjectPlan::find($id);
        if (!$projectPlan) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El proyecto no existe',
                    'detail' => 'Intente con otro proyecto',
                    'code' => '404'
                ]
            ], 400);
        }
        $projectPlan->title = $request->input('projectPlan.title');
        $projectPlan->description = $request->input('projectPlan.description');
        $projectPlan->act_code = $request->input('projectPlan.act_code');
        $projectPlan->approval_date = $request->input('projectPlan.approval_date');
        $projectPlan->is_approved = $request->input('projectPlan.is_approved');
        $projectPlan->observations = $request->input('projectPlan.observations');
        $projectPlan->save();
        return response()->json([
            'data' => $projectPlan,
            'msg' => [
                'summary' => 'Proyecto actualizado',
                'detail' => 'El proyecto fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function delete(DeleteProjectPlanRequest $request)
    {
        ProjectPlan::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Proyectos eliminados',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
