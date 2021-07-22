<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;




use App\Models\Cecy\DetailRegistration;
use App\Models\Cecy\Attendance;
use App\Exports\AttendancesExport;
use App\Http\Requests\Cecy\Attendance\DeleteAttendanceRequest;
use App\Http\Requests\Cecy\Attendance\IndexAttendanceRequest;
use App\Http\Requests\Cecy\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Cecy\Attendance\UpdateAttendanceRequest;

class AttendanceController extends Controller
{

    function index(IndexAttendanceRequest $request)
    
    {
        
        
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        $detailRegistration = DetailRegistration::getInstance($request->input('detail_registration_id'));
    
        if ($request->has('search')) {
            $attendance = $detailRegistration->attendance()
                ->date($request->input('search'))
                ->assistance($request->input('search'))
                ->observation($request->input('search'))
                ->day_hours($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $attendance = Attendance::with("detailRegistration")->paginate($request->input('per_page'));
        }

        if ($attendance->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Habilidades',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
    
        return response()->json($attendance, 200);
    }
    function show(Attendance $attendance)
    {
        return response()->json([
            'data' => $attendance,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code'=> '200'
            ]], 200);
    }

        public function store(StoreAttendanceRequest $request)
    {
        $data = $request -> json() -> all();

        $attendance = new Attendance();
        
        $attendance->detail_registration_id = $request->input('attendances.detail_registration_id');
        $attendance->date = $request->input('attendances.date');
        $attendance->day_hours = $request -> input ('attendances.day_hours');
        $attendance->assistance = $request -> input ('attendances.assistance');
        $attendance->observations = $request->input('attendances.observations');
        $attendance->save();

        return response()->json([
            'data' => $attendance,
            'msg' => [
                'summary' => 'attendance creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {

        $data = $request -> json() -> all();
       

        $attendance->detail_registration_id = $request->input('attendances.detail_registration_id');
        $attendance->date = $request->input('attendances.date');
        $attendance->day_hours = $request -> input ('attendances.day_hours');
        $attendance->assistance = $request -> input ('attendances.assistance');
        $attendance->observations = $request->input('attendances.observations');
        $attendance->save();

        return response()->json([
            'data' => $attendance->fresh(),
            'msg' => [
                'summary' => 'attendance creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteAttendanceRequest $request)
    {
        Attendance::destroy($request->input("ids"));
        // Es una eliminación lógica
        //$Attendance->delete();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Attendance eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }
}


    