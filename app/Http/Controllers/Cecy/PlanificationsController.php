<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller;

//Form Request
use App\Http\Requests\Cecy\EvaluationMechanism\IndexPlanificationRequest;


class PlanificationController extends Controller
{
    //Recuperacion de todos los registros o solo de uno
    function index(IndexPlanification $request){}

    //obtener un único objeto o registro
    function show($planificationId){}

    //Crear un registro 
    function store(StorePlanification $request){}

    
    function update(UpdatePlanification $request, $planificationId){}

    function destroy($planificationId){}
}
