<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\App\FileController;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\Uic\Requirement\IndexRequirementRequest;
use App\Http\Requests\Uic\Requirement\DeleteRequirementRequest;
use App\Http\Requests\Uic\Requirement\StoreRequirementRequest;
use App\Http\Requests\Uic\Requirement\UpdateRequirementRequest;

use App\Models\Uic\Requirement;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequirementRequest $request)
    {
        if ($request->has('search')) {
            $requirements = Requirement::name(($request->input('search')));
        } else {
            $requirements = Requirement::paginate($request->input('per_page'));
        }
        if ($requirements->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron requerimientos',
                    'detail' => 'Intentalo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($requirements);
    }

    public function show(Requirement $requirement)
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

    public function store(StoreRequirementRequest $request)
    {
        $requirement = new Requirement;
        $requirement->name = $request->input('requirement.name');
        $requirement->is_required = $request->input('requirement.is_required');
        $requirement->save();
        return response()->json([
            'data' => $requirement,
            'msg' => [
                'summary' => 'Requerimiento creado',
                'detail' => 'El requerimiento fue creado con exito',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateRequirementRequest $request, $id)
    {
        $requirement = Requirement::find($id);
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
        $requirement->name = $request->input('requirement.name');
        $requirement->is_required = $request->input('requirement.is_required');
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

    function delete(DeleteRequirementRequest $request)
    {
        Requirement::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Requerimiento eliminados',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }


    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Requirement::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, Requirement::getInstance($request->input('id')));
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Requirement::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
