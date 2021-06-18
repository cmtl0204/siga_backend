<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

//models
use App\Models\Cecy\EvaluationMechanism; 
use App\Models\App\Catalogue;
use App\Models\App\Status;


//FormRequest 
use App\Http\Requests\Cecy\EvaluationMechanism\IndexEvaluationMechanismRequest;
use App\Http\Requests\Cecy\EvaluationMechanism\StoreEvaluationMechanismRequest;
use App\Http\Requests\Cecy\EvaluationMechanism\UpdateEvaluationMechanismRequest;
use App\Http\Requests\Cecy\EvaluationMechanism\deleteEvaluationMechanismRequest;


class EvaluationMechanismController extends Controller
{
    function index(IndexEvaluationMechanismRequest $request){

        $evaluationMechanism = EvaluationMechanism::all();

          if ($evaluationMechanism->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Registros',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404 );
          }

         return response()->json($evaluationMechanism, 200);
    }

    
    //obtener un único objeto o registro
    function show(EvaluationMechanism $evaluationMechanism){
        return response()->json([
            'data' => $evaluationMechanism,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    //Crear un registro 
    function store(StoreEvaluationMechanismRequest $request){
        $data = $request->json()->all();

        $status = $data['evaluation_mechanisms']['status'];
        $type = $data['evaluation_mechanisms']['type'];

        $evaluationMechanism = new EvaluationMechanism();
        $evaluationMechanism->technique = $request->input('evaluation_mechanisms.technique');
        $evaluationMechanism->instrument = $request->input('evaluation_mechanisms.instrument');
        $evaluationMechanism->state()->associate(Status::findOrFail($status['id']));
        $evaluationMechanism->type()->associate(Catalogue::findOrFail($type['id']));
        $evaluationMechanism->save();

        return response()->json([
            'data' => $evaluationMechanism,
            'msg' => [
                'summary' => 'Se ha creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);

    }

    //actualizar
     function update(UpdateEvaluationMechanismRequest $request, EvaluationMechanism $evaluationMechanism){

        $data = $request->json()->all();

        $status = $data['evaluation_mechanisms']['status'];
        $type = $data['evaluation_mechanisms']['type'];

        $evaluationMechanism->technique = $request->input('evaluation_mechanisms.technique');
        $evaluationMechanism->instrument = $request->input('evaluation_mechanisms.instrument');
        $evaluationMechanism->state()->associate(Status::findOrFail($status['id']));
        $evaluationMechanism->type()->associate(Catalogue::findOrFail($type['id']));
        $evaluationMechanism->save();

        return response()->json([
            'data' => $evaluationMechanism,
            'msg' => [
                'summary' => 'Se ha actualizado el registro',
                'detail' => 'El registro fue modificado',
                'code' => '201'
            ]], 201);
    }

    //Eliminar
    // function destroy( EvaluationMechanism $evaluationMechanism){
    //     $evaluationMechanism->delete();

    //     return response()->json([
    //         'data' => $evaluationMechanism,
    //         'msg' => [
    //             'summary' => 'Se ha eliminado',
    //             'detail' => 'El registro fue eliminado',
    //             'code' => '201'
    //         ]], 201);
    // }


    function destroy(DeleteEvaluationMechanismRequest $request){
        EvaluationMechanism::destroy($request->input('ids'));
  
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Registro(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
      }
 }
