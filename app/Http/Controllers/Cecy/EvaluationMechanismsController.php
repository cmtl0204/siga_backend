<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller;

//Form Request
use App\Http\Requests\Cecy\EvaluationMechanism\IndexEvaluationMechanismRequest;


class EvaluationMechanismController extends Controller
{
    //Recuperacion de todos los registros o solo de uno
    function index(IndexEvaluationMechanism $request){}

    //obtener un único objeto o registro
    function show($evaluation_mechanismId){}

    //Crear un registro 
    function store(StoreEvaluationMechanism $request){}

    
    function update(UpdateEvaluationMechanism $request, $EvaluationMechanismId){}

    function destroy($evaluation_mechanismId){}
}
