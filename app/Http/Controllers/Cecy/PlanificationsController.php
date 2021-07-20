<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Planification\IndexPlanificationRequest;
use App\Http\Requests\Cecy\Planification\StorePlanificationRequest;
use App\Http\Requests\Cecy\Planification\UpdatePlanificationRequest;
use App\Http\Requests\Cecy\Planification\DeletePlanificationRequest;

use App\Models\Cecy\Planification;
use App\Models\Authentication\User;
use App\Models\App\Catalogue;




//Form Request


class PlanificationsController extends Controller
{
    //Recuperacion de todos los registros o solo de uno
    function index(IndexPlanificationRequest $request){
      $planification = Planification::with('course')->with('teacher')->with('status')->get();

        return response()->json([
            'data' => $planification,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);

            // if($request->has('search')){
            //     $planification = $planification
            // }
    }

    // obtener un único objeto o registro
    function show(Planification $planification){
      return response()->json([
        'data' => $planification->with('course')->first(),
        'msg' => [
            'summary' => 'success',
            'detail' => '',
            'code'=> '200'
        ]], 200);
    }

    //Crear un registro 
    function store(StorePlanificationRequest $request){
      
      $data = $request->json()->all();
      $status = $data['planification']['status'];
      // $teacherResponsable = $data['planification']['teacher_responsable'];

      $planification = new Planification();
      $planification->date_start = $request->input('planification.date_start');
      $planification->date_end = $request->input('planification.date_end');
      $planification->course_id = $request->input('planification.course_id');
      $planification->needs = $request->input('planification.needs');
      $planification->status()->associate(Catalogue::findOrFail($status['id']));
      $planification->teacher_responsable_id = $request->input('planification.teacher_responsable_id');

      // $planification->teacher_responsable()->associate(User::findOrFail($teacherResponsable['id']));

      $planification->save();

      return response()->json([
        'data' => $planification->fresh(),
        'msg' => [
            'summary' => 'Planification fue creada',
            'detail' => 'El registro fue creado con exito',
            'code' => '201'
        ]], 201);

    }

    
    function update(UpdatePlanificationRequest $request, Planification $planification){
      $data = $request->json()->all();
      $status = $data['planification']['status'];
      // $teacherResponsable = $data['planification']['teacher_responsable'];

      $planification->date_start = $request->input('planification.date_start');
      $planification->date_end = $request->input('planification.date_end');
      $planification->course_id = $request->input('planification.course_id');
      $planification->needs = $request->input('planification.needs');
      $planification->status()->associate(Catalogue::findOrFail($status['id']));
      $planification->teacher_responsable_id = $request->input('planification.teacher_responsable_id');

      // $planification->teacher_responsable()->associate(User::findOrFail($teacherResponsable['id']));

      $planification->save();

      return response()->json([
        'data' => $planification->fresh(),
        'msg' => [
            'summary' => 'Planification fue actualizado',
            'detail' => 'El registro fue actualizado con exito',
            'code' => '201'
        ]], 201);
    }

    function destroy(DeletePlanificationRequest $request){
      Planification::destroy($request->input('ids'));

      return response()->json([
          'data' => null,
          'msg' => [
              'summary' => 'Registro(s) eliminado(s)',
              'detail' => 'Se eliminó correctamente',
              'code' => '201'
          ]], 201);
    }
}
