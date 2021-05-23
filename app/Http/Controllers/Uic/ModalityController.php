<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Modality\StoreModalityRequest;
use App\Models\App\Catalogue;
use App\Models\Uic\Modality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
// Models

// FormRequest en el index store update

class ModalityController extends Controller
{
    //Obtener modalidades
    public function index():JsonResponse
    {
       $modalities = Modality::all();
       
       if($modalities->count()===0){
           return response()->json([
               'data'=>null,
               'msg'=>[
                   'summary'=>'No se encontraron modalidades',
                   'detail'=>'Intentelo de nuevo',
                   'code'=>'404'
               ]
           ],400);
       }
       return response()->json([
           'data' =>$modalities
       ],200);
    }    

    public function show($modalityId)
    {
        $modality = Modality::find($modalityId);
        if(!$modality){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La modalidad no existe',
                    'detail'=>'Intente con otra modalidad',
                    'code'=>'404'
                ]
            ],400);
        }
        return response()->json([
            "data"=>$modality
        ],200);
    }
    
    public function showModalities($modalityId)
    {
        $modality = Modality::find($modalityId);
        if(!$modality){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La modalidad no existe',
                    'detail'=>'Intente con otra modalidad',
                    'code'=>'404'
                ]
            ],400);
        }
        return response()->json([
            "data"=>$modality->modalities,
        ],200);
    }

    public function store(StoreModalityRequest $request)
    {
        $modality = new Modality;
        $modality->parent_id=$request->input('parent_id');
        $modality->career_id=$request->input('career_id');
        $modality->name=$request->input('name');
        $modality->setDescriptionAttribute($request->input('description'));
        $modality->status_id=$request->input('status_id');
        $modality->save();
        return response()->json([
            'data'=>$modality->fresh(),
            'msg'=>[
                'summary'=>'Modalidad creada',
                'detail'=>'El registro fue creado',
                'code'=>'201'
            ]
        ],201);

    }

    public function update(Request $request, $id)
    {
        $modality = Modality::find($id);
        if(!$modality){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La modalidad no existe',
                    'detail'=>'Intente con otra modalidad',
                    'code'=>'404'
                ]
            ],400);
        }
        $modality->parent_id=$request->input('parent_id');
        $modality->career_id=$request->input('career_id');
        $modality->name=$request->input('name');
        $modality->description=$request->input('description');
        $modality->status_id=$request->input('status_id');
        $modality->save();
        return response()->json([
            'data'=>$modality->fresh(),
            'msg'=>[
                'summary'=>'Modalidad actualizada',
                'detail'=>'El registro fue actualizado',
                'code'=>'201'
            ]
        ],201);
    }

    public function destroy(Modality $modality)
    {
        $modality->delete();
        if(!$modality){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La modalidad no existe',
                    'detail'=>'Intente con otra modalidad',
                    'code'=>'404'
                ]
            ],400);
        }
        return response()->json([
            'data'=>null,
            'msg'=>[
                'summary'=>'Modalidad eliminada',
                'detail'=>'El registro fue eliminado',
                'code'=>'201'
            ]
        ],201);
    }
}
