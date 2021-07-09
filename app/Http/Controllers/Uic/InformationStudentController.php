<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\InformationStudent\DeleteInformationStudentRequest;
use App\Http\Requests\Uic\InformationStudent\IndexInformationStudentRequest;
use App\Http\Requests\Uic\InformationStudent\StoreInformationStudentRequest;
use App\Http\Requests\Uic\InformationStudent\UpdateInformationStudentRequest;
use App\Models\App\InformationStudent;

// Models

// FormRequest en el index store update

class InformationStudentController extends Controller
{
    public function index(IndexInformationStudentRequest $request)
    {

        $informationStudent = InformationStudent::paginate($request->input('per_page'));

        if ($informationStudent->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron registros',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($informationStudent, 200);
    }

    public function show(InformationStudent $informationStudent)
    {
        if (!$informationStudent) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'la información no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $informationStudent,
            'msg' => [
                'summary' => '',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function store(StoreInformationStudentRequest $request)
    {
        $informationStudent = new InformationStudent;
        $informationStudent->student_id = $request->input('informationStudent.student.id');
        $informationStudent->province_birth = $request->input('informationStudent.province_birth');
        $informationStudent->canton_birth = $request->input('informationStudent.canton_birth');
        $informationStudent->company_work = $request->input('informationStudent.company_work');
        $informationStudent->relation_laboral_career = $request->input('informationStudent.relation_laboral_career');
        $informationStudent->area = $request->input('informationStudent.area');
        $informationStudent->position = $request->input('informationStudent.position');
        $informationStudent->save();
        return response()->json([
            'data' => $informationStudent->fresh(),
            'msg' => [
                'summary' => 'InformationStudent creado',
                'detail' => 'El informationStudent fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateInformationStudentRequest $request, $id)
    {
        $informationStudent = InformationStudent::find($id);
        if (!$informationStudent) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El informationStudent no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        $informationStudent->student_id = $request->input('informationStudent.student.id');
        $informationStudent->province_birth = $request->input('informationStudent.province_birth');
        $informationStudent->canton_birth = $request->input('informationStudent.canton_birth');
        $informationStudent->company_work = $request->input('informationStudent.company_work');
        $informationStudent->relation_laboral_career = $request->input('informationStudent.relation_laboral_career');
        $informationStudent->area = $request->input('informationStudent.area');
        $informationStudent->position = $request->input('informationStudent.position');
        $informationStudent->save();
        return response()->json([
            'data' => $informationStudent->fresh(),
            'msg' => [
                'summary' => 'InformationStudent actualizado',
                'detail' => 'El informationStudent fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }
    function delete(DeleteInformationStudentRequest $request)
    {
        // Es una eliminación lógica
        InformationStudent::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'InformationStudent(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
