<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\App\FileController;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\Uic\MeshStudentRequirement\DeleteMeshStudentRequirementRequest;
use App\Http\Requests\Uic\MeshStudentRequirement\DisapprovedMeshStudentRequirementRequest;
use App\Http\Requests\Uic\MeshStudentRequirement\StoreMeshStudentRequirementRequest;
use App\Http\Requests\Uic\MeshStudentRequirement\UpdateMeshStudentRequirementRequest;
use App\Http\Requests\Uic\MeshStudentRequirement\IndexMeshStudentRequirementRequest;
use App\Models\Uic\MeshStudentRequirement;
use App\Models\Uic\Requirement;

class MeshStudentRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexMeshStudentRequirementRequest $request)
    {
        if ($request->has('student_id')) {
            $meshStudentRequirements = MeshStudentRequirement::student($request->input('student_id'))->get();
        } else {
            $meshStudentRequirements = MeshStudentRequirement::paginate($request->input('per_page'));
        }
        if ($meshStudentRequirements->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron requerimientos',
                    'detail' => 'Intentalo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($meshStudentRequirements, 200);
    }

    public function show(MeshStudentRequirement $meshStudentRequirement)
    {
        if (!$meshStudentRequirement) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El requerimiento no existe',
                    'detail' => 'Intente con otro registro',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $meshStudentRequirement->fresh(),
            'msg' => [
                'summary' => 'El requerimiento no existe',
                'detail' => 'Intente con otro registro',
                'code' => '404'
            ]
        ], 200);
    }

    public function store(StoreMeshStudentRequirementRequest $request)
    {
        $meshStudentRequirement = new MeshStudentRequirement;
        $meshStudentRequirement->mesh_student_id = 1;
        $meshStudentRequirement->requirement_id = $request->input('meshStudentRequirement');
        $meshStudentRequirement->is_approved = $request->input('is_approved');
        $meshStudentRequirement->observations = $request->input('observations');
        $meshStudentRequirement->save();
        return response()->json([
            'data' => $meshStudentRequirement->fresh()
        ], 201);
    }

    public function update(UpdateMeshStudentRequirementRequest $request, $id)
    {
        $meshStudentRequirement = MeshStudentRequirement::find($id);
        if (!$meshStudentRequirement) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El requerimiento no existe',
                    'detail' => 'Intente con otro registro',
                    'code' => '404'
                ]
            ], 400);
        }
        $meshStudentRequirement->mesh_student_id = 1;
        $meshStudentRequirement->requirement_id = $request->input('meshStudentRequirement.requirement.id');
        $meshStudentRequirement->is_approved = $request->input('meshStudentRequirement.is_approved');
        $meshStudentRequirement->observations = $request->input('meshStudentRequirement.observations');
        $meshStudentRequirement->save();
        return response()->json([
            'data' => $meshStudentRequirement,
            'msg' => [
                'summary' => 'Requerimiento actualizado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    public function approve($id)
    {
        $meshStudentRequirement = MeshStudentRequirement::find($id);
        if (!$meshStudentRequirement) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El requerimiento no existe',
                    'detail' => 'Intente con otro registro',
                    'code' => '404'
                ]
            ], 400);
        }
        $meshStudentRequirement->is_approved = true;
        $meshStudentRequirement->save();
        return response()->json([
            'data' => $meshStudentRequirement,
            'msg' => [
                'summary' => 'Requerimiento aprobado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    public function disapproved(DisapprovedMeshStudentRequirementRequest $request, $id)
    {
        $meshStudentRequirement = MeshStudentRequirement::find($id);
        if (!$meshStudentRequirement) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El requerimiento no existe',
                    'detail' => 'Intente con otro registro',
                    'code' => '404'
                ]
            ], 400);
        }
        $meshStudentRequirement->is_approved = false;
        $meshStudentRequirement->observation = $request->input('meshStudentRequirement.observation');;
        $meshStudentRequirement->save();
        return response()->json([
            'data' => $meshStudentRequirement,
            'msg' => [
                'summary' => 'Requerimiento rechazado',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function delete(DeleteMeshStudentRequirementRequest $request)
    {
        MeshStudentRequirement::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Requerimiento eliminado',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }

    function uploadFile(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, MeshStudentRequirement::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, MeshStudentRequirement::getInstance($request->input('id')));
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, MeshStudentRequirement::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
