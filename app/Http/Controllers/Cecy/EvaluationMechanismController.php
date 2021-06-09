<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller; 

//models
use App\Models\Cecy\EvaluationMechanism; 


//Form Request index store update requiere un request
use App\Http\Requests\Cecy\EvaluationMechanism\StoreEvaluationMechanismRequest;


class EvaluationMechanismController extends Controller
{
    function index(IndexEvaluationMechanism $request){
    //Crea una instancia  del modelo profesional para poder insertar en el modelo skill.

    $docentes = Docentes::getInstance($request->input(key:'docentes_id'));

    if($request->has(key:'search')){
        $$
    } else {};

    return response()->json($docentes, status:200);
    }

    //obtener un único objeto o registro
    function show($evaluation_mechanismId){}

    //Crear un registro 
    function store(StoreEvaluationMechanism $request){}

    
    function update(UpdateEvaluationMechanism $request, $EvaluationMechanismId){}

    function destroy($evaluation_mechanismId){}
}
