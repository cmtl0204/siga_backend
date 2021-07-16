<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\App\FileController;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\Uic\RequirementRequest\IndexRequirementRequestRequest;
use App\Http\Requests\Uic\RequirementRequest\DeleteRequirementRequestRequest;
use App\Http\Requests\Uic\RequirementRequest\StoreRequirementRequestRequest;
use App\Http\Requests\Uic\RequirementRequest\UpdateRequirementRequestRequest;

use App\Models\Uic\RequirementRequest;

class RequirementRequestRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequirementRequestRequest $request)
    {
        if ($request->has('search')) {
            $requirementRequests = RequirementRequest::name(($request->input('search')))->paginate($request->input('per_page'));
        } else {
            $requirementRequests = RequirementRequest::paginate($request->input('per_page'));
        }
        if ($requirementRequests->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron requerimientos',
                    'detail' => 'Intentalo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($requirementRequests);
    }

    public function show(RequirementRequest $requirement)
    {
        if (!$requirement) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El requerimiento no existe',
                    'detail' => 'Intente con otro requerimiento',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $requirement,
            'msg' => [
                'summary' => '',
                'detail' => '',
                'code' => '200'
            ]

        ], 200);
    }

    public function store(StoreRequirementRequestRequest $request)
    {
        $requirement = new RequirementRequest;
        $requirement->requirement_id = $request->input('requirementRequest.requirement.id');
        $requirement->mesh_student_id = $request->input('requirementRequest.mesh_student.id');
        $requirement->date = $request->input('requirementRequest.date');
        $requirement->is_approved = $request->input('requirementRequest.is_approved');
        $requirement->save();
        return response()->json([
            'data' => $requirement->fresh(),
            'msg' => [
                'summary' => 'Requerimiento creado',
                'detail' => 'El requerimiento fue creado con exito',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateRequirementRequestRequest $request, $id)
    {
        $requirement = RequirementRequest::find($id);
        if (!$requirement) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El requerimiento no existe',
                    'detail' => 'Intente con otro requerimiento',
                    'code' => '404'
                ]
            ], 400);
        }
        $requirement->requirement_id = $request->input('requirementRequest.requirement.id');
        $requirement->mesh_student_id = $request->input('requirementRequest.mesh_student.id');
        $requirement->date = $request->input('requirementRequest.date');
        $requirement->is_approved = $request->input('requirementRequest.is_approved');
        $requirement->save();
        return response()->json([
            'data' => $requirement->fresh(),
            'msg' => [
                'summary' => 'Requerimiento actualizado',
                'detail' => 'El requerimiento fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function delete(DeleteRequirementRequestRequest $request)
    {
        RequirementRequest::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Requerimiento eliminados',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
