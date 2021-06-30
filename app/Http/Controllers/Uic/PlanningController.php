<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Planning\DeletePlanningRequest;
use App\Http\Requests\Uic\Planning\IndexPlanningRequest;
use App\Http\Requests\Uic\Planning\StorePlanningRequest;
use App\Http\Requests\Uic\Planning\UpdatePlanningRequest;
use App\Models\Uic\Planning;
use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Models

// FormRequest en el index store update

class PlanningController extends Controller
{
    public function index(IndexPlanningRequest $request){
        $hoy = Carbon::today();
        $hoy->format('Y-m-d h:m:s');

        if ($request->has('search')) {
           
            $plannings = Planning::name($request->input('search'))
                ->event($request->input('search'))
                ->description($request->input('search'))
                ->startDate($request->input('search'))
                ->endDate($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $plannings = Planning::where('end_date', '>=', $hoy)->paginate($request->input('per_page')); //Where date se encarga de hacer la comparación entre  fechas
            // $planningsEnd = Planning::where('end_date', '<', $hoy)->paginate($request->input('per_page')); //Where date se encarga de hacer la comparación entre  fechas
            // $plannings = Planning::orderBy('id','desc')->with('files')->paginate($request->input('per_page'));
        }

        if($plannings->count()===0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron planificaciones',
                    'detail'=>'Intentelo de nuevo',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json($plannings,200);
    }

     public function indexEnd(IndexPlanningRequest $request){
        $hoy = Carbon::today();
        $hoy->format('Y-m-d h:m:s');
        if ($request->has('search')) {
            $planningsEnd = Planning::where('end_date', '<', $hoy)->name($request->input('search'))
                ->event($request->input('search'))
                ->description($request->input('search'))
                ->startDate($request->input('search'))
                ->endDate($request->input('search'));
        } else {

            // $plannings = Planning::where('end_date', '>=', $hoy)->paginate($request->input('per_page')); //Where date se encarga de hacer la comparación entre  fechas
            $planningsEnd = Planning::where('end_date', '<', $hoy); //Where date se encarga de hacer la comparación entre  fechas
            // $plannings = Planning::orderBy('id','desc')->with('files')->paginate($request->input('per_page'));
        }

        if($planningsEnd->count()===0){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'No se encontraron planificaciones pasadas',
                    'detail'=>'Intentelo de nuevo',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json($planningsEnd,200);
    }


    public function show($planningId)
    {
        $planning = Planning::find($planningId);
        if(!$planning){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La planificacion no existe',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],404);
        }
        return response()->json([
            'data'=>$planning
        ],200);
    }

    public function store(StorePlanningRequest $request)
    {
        $planning = new Planning;
        if($request->input('planning.start_date') <= $request->input('planning.end_date')){
            $planning->name=$request->input('planning.name');
            $planning->number=$request->input('planning.number');
            $planning->start_date=$request->input('planning.start_date');
            $planning->end_date=$request->input('planning.end_date');
            $planning->description=$request->input('planning.description');
            $planning->save();
            return response()->json([
                'data'=>$planning->fresh(),
                'msg'=>[
                    'summary'=>'Planificacion creada',
                    'detail'=>'La planificacion fue creado',
                    'code'=>'201'
                ]
            ],201);
        }
         return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La fecha final debe ser mayor a la fecha de inicio',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],404);
    }

    public function update(UpdatePlanningRequest $request, $id)
    {
        $planning = Planning::find($id);
        if(!$planning){
            return response()->json([
                'data'=>null,
                'msg'=>[
                    'summary'=>'La planificacion no existe',
                    'detail'=>'Intente otra vez',
                    'code'=>'404'
                ]
            ],400);
        }
        $planning->name=$request->input('planning.name');
        $planning->number=$request->input('planning.number');
        $planning->start_date=$request->input('planning.start_date');
        $planning->end_date=$request->input('planning.end_date');
        $planning->description=$request->input('planning.description');
        $planning->save();
        return response()->json([
            'data'=>$planning->fresh(),
            'msg'=>[
                'summary'=>'PLanificación actualizada',
                'detail'=>'La planificacion fue actualizado',
                'code'=>'201'
            ]
        ],201);
    }
    function delete(DeletePlanningRequest $request)
    {
        // Es una eliminación lógica
        Planning::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Planificacion(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
     function uploadFile(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Planning::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, Planning::getInstance($request->input('id')));

    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Planning::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
