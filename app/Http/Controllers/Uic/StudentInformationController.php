<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\StudentInformation\DeleteStudentInformationRequest;
use App\Http\Requests\Uic\StudentInformation\IndexStudentInformationRequest;
use App\Http\Requests\Uic\StudentInformation\StoreStudentInformationRequest;
use App\Http\Requests\Uic\StudentInformation\UpdateStudentInformationRequest;
use App\Models\Uic\StudentInformation;

// Models

// FormRequest en el index store update

class StudentInformationController extends Controller
{
    public function index(IndexStudentInformationRequest $request)
    {

        $informationStudent = StudentInformation::paginate($request->input('per_page'));

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

    public function show(StudentInformation $informationStudent)
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

    public function store(StoreStudentInformationRequest $request)
    {
        $informationStudent = new StudentInformation;
        $informationStudent->student_id = $request->input('informationStudent.student.id');
        $informationStudent->company_work = $request->input('informationStudent.company_work');
        $informationStudent->relation_laboral_career_id = $request->input('informationStudent.relation_laboral_career.id');
        $informationStudent->company_area_id = $request->input('informationStudent.company_area.id');
        $informationStudent->company_position_id = $request->input('informationStudent.company_position.id');
        $informationStudent->save();
        return response()->json([
            'data' => $informationStudent->fresh(),
            'msg' => [
                'summary' => 'StudentInformation creado',
                'detail' => 'El informationStudent fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateStudentInformationRequest $request, $id)
    {
        $informationStudent = StudentInformation::find($id);
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
        $informationStudent->company_work = $request->input('informationStudent.company_work');
        $informationStudent->relation_laboral_career_id = $request->input('informationStudent.relation_laboral_career.id');
        $informationStudent->company_area_id = $request->input('informationStudent.company_area.id');
        $informationStudent->company_position_id = $request->input('informationStudent.company_position.id');
        $informationStudent->save();
        return response()->json([
            'data' => $informationStudent->fresh(),
            'msg' => [
                'summary' => 'StudentInformation actualizado',
                'detail' => 'El informationStudent fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }
    function delete(DeleteStudentInformationRequest $request)
    {
        // Es una eliminación lógica
        StudentInformation::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'StudentInformation(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
