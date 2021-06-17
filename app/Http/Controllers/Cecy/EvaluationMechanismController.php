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
        $evaluationMechanisms = EvaluationMechanism::all();
        if ($evaluationMechanisms->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Registros',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($evaluationMechanisms, 200);
    };

    
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
        $type = Type::getInstance($request->input('type.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $type = Catalogue::getInstance($request->input('type.id'));

        $evaluationMechanism = new EvaluationMechanism();
        $evaluationMechanism->type()->associate($type);
        $evaluationMechanism->status()->associate($status);
        $evaluationMechanism->technique = $request->input('$evaluationMechanism.technique');
        $evaluationMechanism->instrument = $request->input('$evaluationMechanism.instrument');
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
    function update(UpdateEvaluationMechanismRequest $request, EvaluationMechanism $EvaluationMechanism){

        $evaluationMechanism->type()->asociate($type);
        $evaluationMechanism->status()->associate($status);
        $evaluationMechanism->technique = $request->input('$evaluationMechanism.technique');
        $evaluationMechanism->instrument = $request->input('$evaluationMechanism.instrument');
        $evaluationMechanism->save();

        return response()->json([
            'data' => $evaluationMechanism,
            'msg' => [
                'summary' => 'Se ha creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    //Eliminar
    function destroy( EvaluationMechanism $evaluationMechanism){
        // Es una eliminación lógica
        $evaluationMechanism->delete();

        return response()->json([
            'data' => $evaluationMechanism,
            'msg' => [
                'summary' => 'Se ha eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }
}
