<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller; 

//models
use App\Models\Cecy\EvaluationMechanism; 
use App\Models\App\Catalogue;

//FormRequest 
use App\Http\Requests\Cecy\EvaluationMechanism\IndexEvaluationMechanismRequest;
use App\Http\Requests\Cecy\EvaluationMechanism\StoreEvaluationMechanismRequest;
use App\Http\Requests\Cecy\EvaluationMechanism\UpdateEvaluationMechanismRequest;


class EvaluationMechanismController extends Controller
{
    function index(IndexEvaluationMechanismRequest $request){
    //Crea una instancia  del modelo profesional para poder insertar en el modelo evalution_mechanism.
    $type = Type::getInstance($request->input('type.id'));
        //$types = Type::all();
        
        if($evaluation_mechanisms->count() === 0){
            return response()->json([ 
                'data'=> null,
                'msg'=> [
                    'detail'=> 'No se encontraron registros, intente denuevo.'
                ]
             ], 404);
        } else{
            return response()->json[ 
            'data'=> [ 
                 'type' => $type
             ]
         ], 200);
        }
    };

    
    //obtener un único objeto o registro
    function show(EvaluationMechanism $evaluation_mechanism){
        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    //Crear un registro 
    function store(StoreEvaluationMechanismRequest $request){
        $type = Type::getInstance($request->input('type.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $type = Catalogue::getInstance($request->input('type.id'));

        $evaluation_mechanism = new EvaluationMechanism();
        $evalution_mechanism->type()->associate($type);
        $evalution_mechanism->status()->associate($status);
        $evaluation_mechanism->technique = $request->input('evaluation_mechanism.technique');
        $evaluation_mechanism->instrument = $request->input('evaluation_mechanism.instrument');
        $evalution_mechanism->save();

        return response()->json([
            'data' => $evalution_mechanism,
            'msg' => [
                'summary' => 'Se ha creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);

    }

    //actualizar
    function update(UpdateEvaluationMechanismRequest $request, EvaluationMechanism $EvaluationMechanismId){

        $evalution_mechanism->type()->associate($type);
        $evalution_mechanism->status()->associate($status);
        $evaluation_mechanism->technique = $request->input('evaluation_mechanism.technique');
        $evaluation_mechanism->instrument = $request->input('evaluation_mechanism.instrument');
        $evalution_mechanism->save();

        return response()->json([
            'data' => $evalution_mechanism,
            'msg' => [
                'summary' => 'Se ha creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    //Eliminar
    function destroy( EvaluationMechanism $evaluation_mechanism){
        // Es una eliminación lógica
        $skill->delete();

        return response()->json([
            'data' => $evaluation_mechanism,
            'msg' => [
                'summary' => 'Se ha eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }
}
