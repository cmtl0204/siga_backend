<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Planification\createPlanificationRequest;
use App\Http\Requests\Cecy\Planification\IndexRequest;
use App\Http\Requests\Cecy\Planification\ShowByIdPlanificationRequest;
use App\Http\Requests\Cecy\Planification\UpdatePlanificationRequest;
use App\Models\App\Status;
use App\Models\Authentication\User;
use App\Models\Cecy\Course;
use App\Models\Cecy\Planification;
use Illuminate\Http\Request;

class PlanificationController extends Controller
{

    //Traer todas las planificaciones
    function getPlanifiations(IndexRequest $request)
    {

        $planifications =  Planification::with('course','user')->paginate($request->input('per_page'));

        return response()->json($planifications, 200);
    }

    //Crear un planificacion
    function  createPlanification(createPlanificationRequest $request)
    {
        $course = Course::getInstance($request->input('planification.course.id')); // realacion con courses
        $user = User::getInstance($request->input('planification.user.id'));// relacion con user para asigancion de usurio cecy responsable
        $status = Status::getInstance($request->input('planification.status.id')); //relacion con status tatbla catalogues

        $planification = new Planification();
        $planification->date_start = $request->input('planification.date_start');
        $planification->date_end = $request->input('planification.date_end');
        $planification->course()->associate($course);
        $planification->user()->associate($user);
        $planification->status()->associate($status);
        $planification->needs = $request->input('planification.needs');
        $planification->save();

        return response()->json([
            'data' => $planification->with('course','user')->get(),
            'msg' => [
                'summary' => 'Planificacion Creada',
                'detail' => 'La planificacion fue creadda con exitos',
                'code' => '201'
            ]
        ], 201);
    }
  
  
    //Modificar una planificaion 
    function  updatePlanification(UpdatePlanificationRequest $request, Planification $planification)
    {

        $course = Course::getInstance($request->input('planification.course.id')); // realacion con courses
        $user = User::getInstance($request->input('planification.user.id'));// relacion con user para asigancion de usurio cecy responsable
        $status = Status::getInstance($request->input('planification.status.id')); //relacion con status tatbla catalogues


        $planification->date_start = $request->input('planification.date_start');
        $planification->date_end = $request->input('planification.date_end');
        $planification->course()->associate($course);
        $planification->user()->associate($user);
        $planification->status()->associate($status);
        $planification->needs = $request->input('planification.needs');
        $planification->save();

        return response()->json([
            'data' => $planification->fresh(),
            'msg' => [
                'summary' => 'Planificacion actualizada',
                'detail' => 'La planificacion fue actualizada exitosamente',
                'code' => '201'
            ]
        ], 201);
    }


       //Modificar una planificaion 
       function  showByIdPlanification(ShowByIdPlanificationRequest $request, $planificationID)
       {
        $planification = Planification::where( 'id' ,$planificationID)->with('course','user')->get();
         
           return response()->json([
               'data' => $planification,
               'msg' => [
                   'summary' => 'Planificacion actualizada',
                   'detail' => 'La planificacion fue actualizada exitosamente',
                   'code' => '201'
               ]
           ], 201);
       }

    
}
