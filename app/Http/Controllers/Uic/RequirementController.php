<?php

namespace App\Http\Controller\Uic;

use Illuminate\Http\Request;
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
        $requirement = Requirement::paginate($request->input('per_page'));
        if($requirement->count()==0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron requerimientos',
                    'detail'=>'Intentalo de nuevo',
                    'code'=>'404'
                ]
            ], 404);
        }
    }

    public function show($requirementId)
    {
        $requirement = Requirement::find($requirementId);
        if(!$requirement){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'El requerimiento no existe',
                    'detail'=>'Intente con otro requerimiento',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json([
            'data'=>$requirement
        ],200);
    }

    public function store(StoreRequirementRequest $request)
    {
        $requirement = new Requirement;
        $requirement->name=$request->input('requirement.name');
        $requirement->is_required=$request->input('requirement.is_required');
        $requirement->save();
        return response()->json([
            'data'=>$requirement->fresh(),
            'msg'=>[
                'summary'=>'Requerimiento creado',
                'detail'=>'El requerimiento fue creado con exito',
                'code'=>'201'
            ]
        ],201);
    }

    public function update(UpdateRequirementRequest $request, $id)
    {
        $requirement = Requirement::find($id);
        if(!$requirement){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'El requerimiento no existe',
                    'detail'=>'Intente con otro requerimiento',
                    'code'=>'404'
                ]
            ],400);
        }
        $requirement->name=$request->input('requirement.name');
        $requirement->is_required=$request->input('requirement.is_required');
        $requirement->save();
        return response()->json([
            'data'=>$requirement->fresh(),
            'msg'=>[
                'summary'=>'Requerimiento actualizado',
                'detail'=>'El requerimiento fue actualizado',
                'code'=>'201'
            ]
        ],201);
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
            ]], 201);
    }
}
