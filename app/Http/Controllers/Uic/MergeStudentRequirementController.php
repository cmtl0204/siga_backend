<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\MergeStudentRequirement\DeleteMergeStudentRequirementRequest;
use App\Http\Requests\Uic\MergeStudentRequirement\StoreMergeStudentRequirementRequest;
use App\Http\Requests\Uic\MergeStudentRequirement\UpdateMergeStudentRequirementRequest;
use App\Http\Requests\Uic\MergeStudentRequirement\IndexMergeStudentRequirementRequest;
use App\Models\MergeStudentRequirement;
use App\Models\Uic\Requirement;
//use App\Models\Uic\MergeStudents;

class MergeStudentRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexMergeStudentRequirementRequest $request)
    {
        $mergeStudentRequirements = MergeStudentRequirement::paginate($request->input('per_page'));
        if($mergeStudentRequirements->count()==0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron registros',
                    'detail'=>'Intentalo de nuevo',
                    'code'=>'404'
                ]
            ], 404);
        }
        return response()->json($mergeStudentRequirements);
    }

    public function show($mergeStudentRequirementId)
    {
        $mergeStudentRequirement = MergeStudentRequirement::find($mergeStudentRequirementId);
        if(!$mergeStudentRequirement){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'El registro no existe',
                    'detail'=>'Intente con otro registro',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json([
            'data'=>$mergeStudentRequirement
        ],200);
    }

    public function store(StoreMergeStudentRequirementRequest $request)
    {
        $mergeStudentRequirement = new MergeStudentRequirement;
        $mergeStudentRequirement->student_id=$request->input('mergeStudentRequirement.student_id');
        $mergeStudentRequirement->requirement_id=$request->input('mergeStudentRequirement.requirement_id');
        $mergeStudentRequirement->save();
        return response()->json([
            'data'=>$mergeStudentRequirement->fresh(),
            'msg'=>[
                'summary'=>'Registro creado',
                'detail'=>'El registro fue creado con exito',
                'code'=>'201'
            ]
        ],201);
    }

    public function update(UpdateMergeStudentRequirementRequest $request, $id)
    {
        $mergeStudentRequirement = MergeStudentRequirement::find($id);
        if(!$mergeStudentRequirement){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'El registro no existe',
                    'detail'=>'Intente con otro registro',
                    'code'=>'404'
                ]
            ],400);
        }
        $mergeStudentRequirement->student_id=$request->input('mergeStudentRequirement.student_id');
        $mergeStudentRequirement->requirement_id=$request->input('mergeStudentRequirement.requirement_id');
        $mergeStudentRequirement->save();
        return response()->json([
            'data'=>$mergeStudentRequirement->fresh(),
            'msg'=>[
                'summary'=>'Registro actualizado',
                'detail'=>'El registro fue actualizado',
                'code'=>'201'
            ]
        ],201);
    }

    function delete(DeleteMergeStudentRequirementRequest $request)
    {
        MergeStudentRequirement::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Rgistro eliminado',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
}
