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
use App\Models\App\Teacher;
use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Models\Uic\Student;
use App\Models\Uic\Tutor;

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
            $projectPlans = ProjectPlan::with(['tutors', 'students'])->paginate($request->input('per_page'));
        }
        if ($projectPlans->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron actas de aprobación del anteproyecto',
                    'detail' => 'Intentalo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($projectPlans, 200);
    }
	
	public function getTeachers(Request $request)
    {
        $teachers = Teacher::with('user')->get();
        if ($teachers->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron docentes',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json(
		[
                'data' => $teachers,
                'msg' => [
                    'summary' => 'Success',
                    'detail' => 'Success',
                    'code' => '200'
                ]
				]
		, 200);
    }

    public function show(ProjectPlan $projectPlan)
    {
        if (!$projectPlan) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El acta de aprobación del anteproyecto no existe',
                    'detail' => 'Intente con otro acta de aprobación del anteproyecto',
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

        $students = $request->input('projectPlan.students');
        for ($i = 0; $i < count($students); $i++) {
            $id = $students[$i]['id'];
            $student = Student::findOrFail($id);
            $student->project_plan_id = $projectPlan->id;
            $student->save();
        }

        $teachers = $request->input('projectPlan.teachers');
		foreach($teachers as $teacher){
            $tutor = Tutor::where('teacher_id','=',$teacher->id)->where('project_plan_id', '=',$projectPlan->id )->first();
			if(!$tutor){
				$tutor = new Tutor();
			}
				
            //$teacher = Teacher::findOrFail($id);
            $tutor->projectPlan()->associate($projectPlan);
			$tutor->teacher()->associate($teacher);
            $tutor->save();
        }
        return response()->json([
            'data' => $projectPlan->fresh(),
            'msg' => [
                'summary' => 'Acta creado',
                'detail' => 'El acta de aprobación del anteproyecto fue creado con exito',
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
                    'summary' => 'El acta de aprobación del anteproyecto no existe',
                    'detail' => 'Intente con otro acta',
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
            'data' => $projectPlan->fresh(),
            'msg' => [
                'summary' => 'Acta actualizado',
                'detail' => 'El acta de aprobación del anteproyecto fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function delete(DeleteProjectPlanRequest $request)
    {
        // $projectPlans = $request->input('ids');

        // for ($i = 0; $i < count($projectPlans); $i++) {
        //     $projectPlan = ProjectPlan::findOrFail($projectPlans[$i]);
        //     $students = $projectPlan->students;


        //     for ($s = 0; $s < count($students); $s++) {
        //         $id = $students[$s]['id'];
        //         $student = Student::findOrFail($id);
        //         $student->project_plan_id = null;

        //         $student->save();
        //         $student->fresh();
        //     }

        //     $tutors = $projectPlan->tutors;

        //     for ($t = 0; $t < count($tutors); $t++) {
        //         $idT = $tutors[$t]['id'];
        //         $tutor = Tutor::findOrFail($idT);
        //         $tutor->project_plan_id = null;
        //         $tutor->save();
        //         $tutor->fresh();
        //     }
        // }

        ProjectPlan::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Actas eliminados',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }

    function uploadFile(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, ProjectPlan::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, ProjectPlan::getInstance($request->input('id')));
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, ProjectPlan::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
